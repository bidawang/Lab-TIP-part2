<?php
namespace App\Http\Controllers;

use App\Models\mdlalat;
use App\Models\mdlbeli;
use App\Models\mdlbahan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

class belictrl extends Controller
{
    public function index(){
        $beli = mdlbeli::all();
        return view('Laboran/Pembelian.beli', ['beli' => $beli]);
    }

    public function print(){
        $endDate = Carbon::now()->toDateString();
        $startDate = Carbon::now()->subDays(30)->toDateString();
        $beli = mdlbeli::whereBetween('created_at', [$startDate, $endDate])->get();
        // Kirim data hasil pencarian ke view
        return view('Laboran/Pembelian.beliprint', compact('beli', 'startDate', 'endDate'));
    }
    
    public function search(Request $request)
{
    $request->validate([
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'jenis' => 'required|in:bahan,alat,all',  // Include 'all' as a valid option
    ]);

    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $jenis = $request->input('jenis');

    // Build query based on date range and jenis
    $query = mdlbeli::whereBetween('created_at', [$startDate, $endDate]);

    if ($jenis !== 'all') {
        $query->where('jenis', $jenis);
    }

    $beli = $query->get();

    // Kirim data hasil pencarian ke view
    return view('Laboran/Pembelian.beliprint', compact('beli', 'startDate', 'endDate', 'jenis'));
}

    
public function insert(Request $request)
{
    // Validasi data input
    $validasidata = $request->validate([
        'nama_barang' => 'required',
        'google_id' => 'required',
        'nama_toko' => 'required',
        'harga' => 'required',
        'jenis' => 'required',
        'satuan' => 'required',
        'jumlah' => 'required',
        'keterangan' => 'required',
        'foto_pembelian' => 'required|image|mimes:jpeg,png,jpg,gif',
    ]);

    // Ambil nilai jumlah dan satuan dari request
    $jumlah = $request->input('jumlah');
    $satuan = $request->input('satuan');

    // Konversi nilai berdasarkan pilihan satuan
    switch ($satuan) {
        case 'liter':
            // Konversi liter ke ml
            $jumlah *= 1000;
            $satuan = 'ml';
            break;
        case 'kg':
            // Konversi kg ke gram
            $jumlah *= 1000;
            $satuan = 'gram';
            break;
        case 'ml':
            // Satuan ml tidak perlu konversi
            break;
        case 'gram':
            // Satuan gram tidak perlu konversi
            break;
        default:
            // Penanganan untuk satuan lain jika diperlukan
            break;
    }

    // Simpan file foto pembelian dengan nama unik
    $gambar = $request->file('foto_pembelian');
    $namaFile = uniqid() . '.' . $gambar->getClientOriginalExtension();
    $validasidata['foto_pembelian'] = $namaFile;

    // Buat entri baru dalam tabel mdlbeli
    $pembelian = mdlbeli::create($validasidata);

    // Handle penambahan stok berdasarkan jenis barang (bahan atau alat)
    if ($validasidata['jenis'] == 'bahan') {
        $bahan = mdlbahan::where('nama_bahan', $validasidata['nama_barang'])->first();
        if ($bahan) {
            $bahan->stok += $jumlah; // Tambahkan jumlah baru ke stok bahan yang sudah ada
            $bahan->save();
        } else {
            $valbahan = [
                'nama_bahan' => $validasidata['nama_barang'],
                'satuan' => $satuan, // Gunakan satuan yang telah diubah jika kg atau liter
                'stok' => $jumlah, // Gunakan jumlah yang telah dikonversi
                'google_id' => $validasidata['google_id'],
                'foto_bahan' => $namaFile,
                'keterangan' => $validasidata['keterangan']
            ];
            mdlbahan::create($valbahan);
        }
    } elseif ($validasidata['jenis'] == 'alat') {
        $alat = mdlalat::where('nama_alat', $validasidata['nama_barang'])->first();
        if ($alat) {
            $alat->stok += $jumlah; // Tambahkan jumlah baru ke stok alat yang sudah ada
            $alat->save();
        } else {
            $valalat = [
                'nama_alat' => $validasidata['nama_barang'],
                'satuan' => $satuan, // Gunakan satuan yang telah diubah jika kg atau liter
                'stok' => $jumlah, // Gunakan jumlah yang telah dikonversi
                'google_id' => $validasidata['google_id'],
                'keterangan' => $validasidata['keterangan'],
                'foto_alat' => $namaFile,
            ];
            mdlalat::create($valalat);
        }
    }

    // Determine the appropriate folder for saving the photo based on the type of item (bahan or alat)
    if ($validasidata['jenis'] == 'bahan') {
        $folderTujuan = public_path('Foto Bahan');
    } elseif ($validasidata['jenis'] == 'alat') {
        $folderTujuan = public_path('Foto Alat');
    }

    // Ensure the target folder exists, if not create a new folder
    if (!file_exists($folderTujuan)) {
        mkdir($folderTujuan, 0777, true);
    }

    // Move the uploaded file to the target folder
    $gambar->move($folderTujuan, $namaFile);

    // Copy the file to an additional folder 'Foto Beli'
    $folderTambahan = public_path('Foto Beli');
    if (!file_exists($folderTambahan)) {
        mkdir($folderTambahan, 0777, true);
    }
    copy($folderTujuan . '/' . $namaFile, $folderTambahan . '/' . $namaFile);

    // Redirect to the 'beli' page with success message
    return redirect()->route('beli')->with('success', 'Data Berhasil Ditambahkan');
}



    public function delete(Request $request){
        $id = $request->input('id_pembelian');

        // Temukan data berdasarkan ID
        $beli = mdlbeli::find($id);

        if(!$beli){
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Hapus foto dari direktori
        $fotoPath = public_path('Foto Beli/'.$beli->foto_pembelian);
        if(File::exists($fotoPath)) {
            File::delete($fotoPath);
        }

        // Hapus data dari database
        $beli->delete();

        return redirect()->route('beli')->with('message', 'Data Berhasil Dihapus');
    }
    public function update(Request $request)
    {
        $id = $request->input('id_pembelian');
        // Validasi data jika diperlukan
        $request->validate([
            'nama_barang' => 'required',
            'harga' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'satuan' => 'required|in:ml,gram', // Sesuaikan dengan pilihan satuan Anda
            'jenis' => 'required|in:alat,bahan', // Sesuaikan dengan pilihan jenis Anda
        ]);

        // Temukan data berdasarkan ID
        $pembelian = mdlbeli::findOrFail($id);

        // Update data pembelian dengan data yang baru
        $pembelian->nama_barang = $request->input('nama_barang');
        $pembelian->harga = $request->input('harga');
        $pembelian->jumlah = $request->input('jumlah');
        $pembelian->satuan = $request->input('satuan');
        $pembelian->jenis = $request->input('jenis');
        $pembelian->keterangan = $request->input('keterangan');

        // Proses upload gambar jika ada file baru yang diunggah
        if ($request->hasFile('foto_pembelian')) {
            // Hapus foto lama jika ada
            if ($pembelian->foto_pembelian) {
                $fotoPath = public_path('Foto Beli/' . $pembelian->foto_pembelian);
                if (File::exists($fotoPath)) {
                    File::delete($fotoPath);
                }
            }

            // Proses upload foto baru
            $file = $request->file('foto_pembelian');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('Foto Beli'), $fileName);

            // Simpan nama file foto baru
            $pembelian->foto_pembelian = $fileName;
        }

        // Simpan perubahan
        $pembelian->save();

        // Redirect atau kembalikan data JSON sesuai kebutuhan aplikasi Anda
        return redirect()->back()->with('success', 'Data pembelian berhasil diperbarui');
    }
}
