<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\mblbmn;
use App\Models\mdlalat;
use App\Models\mdlalatpjm;
use Illuminate\Http\Request;

class alatpjmctrl extends Controller
{
    public function index(){
        $google_id = auth()->user()->google_id;
        $alat = mdlalatpjm::where('google_id', $google_id)->get();
        return view('Laboran/Alat Pinjam.alatpjm', compact('alat'));
        
    }

    public function tindex(){
        $alat = mdlalat::all();

        return view('Laboran/Alat Pinjam.tambahalatpjm',compact('alat'));
    }
    
    public function print() {
        // Mengambil tanggal hari ini dan 30 hari sebelumnya
        $endDate = Carbon::now()->toDateString();
        $startDate = Carbon::now()->subDays(30)->toDateString();
        $alatpjm = mdlalatpjm::whereBetween('created_at', [$startDate, $endDate])->get();
        $alat = mdlalat::all();    
        return view('Laboran/Alat Pinjam.printtalatpjm', compact('alatpjm', 'alat', 'startDate', 'endDate'));
    }
    
    
    public function search(Request $request) {
        // Ambil input tanggal dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Validasi input
        if (!$startDate || !$endDate) {
            // Handle error jika salah satu tanggal tidak diberikan
            return redirect()->back()->withErrors('Tanggal mulai dan tanggal selesai diperlukan');
        }
    
        try {
            // Lakukan pencarian berdasarkan rentang waktu
            $endDateFormatted = Carbon::parse($endDate)->endOfDay(); // Pastikan untuk menggunakan akhir hari untuk tanggal selesai
            $alatpjm = mdlalatpjm::whereBetween('created_at', [$startDate, $endDateFormatted])->get();
            $alat = mdlalat::all(); // Mengapa mengambil semua data alat? Sesuaikan jika tidak diperlukan.
            
            // Kirim data hasil pencarian ke view
            return view('Laboran/Alat Pinjam.printtalatpjm', compact('alatpjm', 'alat', 'startDate', 'endDate'));
        } catch (\Exception $e) {
            // Handle error jika terjadi kesalahan
            return redirect()->back()->withErrors('Terjadi kesalahan saat melakukan pencarian.');
        }
    }
    
    
    public function insert(Request $request)
{
    $validatedData = $request->validate([
        'nama_peminjam' => 'required',
        'nama_alat.*' => 'required', // Membuat nama_alat menjadi array
        'jumlah.*' => 'required', // Membuat jumlah menjadi array
        'satuan.*' => 'required', // Membuat satuan menjadi array
        'tempat_peminjaman' => 'required',
        'tanggal_peminjaman' => 'required',
        'keperluan' => 'required',
        'google_id' => 'required',
        'status' => 'required'
    ]);

    // Ambil tanggal dan buat bagian kode yang statis
    $tanggal = Carbon::parse($validatedData['tanggal_peminjaman']);
    $hari = $tanggal->locale('id')->isoFormat('ddd'); // Mendapatkan hari dalam bahasa Indonesia
    $tanggalHari = $tanggal->format('d'); // Tanggal dalam format dd
    $bulanRomawi = $this->bulanRomawi($tanggal->format('m')); // Mengambil bulan dalam romawi
    $tahunAkhir = $tanggal->format('y'); // Dua angka terakhir tahun

    // Mencari urutan berdasarkan tanggal hari ini
    $urutan = mdlalatpjm::whereDate('tanggal_peminjaman', $tanggal->toDateString())->count() + 1;

    // Membuat kode alat pinjam
    $kodeAlatPinjam = 'ALT_' . ucfirst(strtolower(substr($hari, 0, 3))) . '/' . $tanggalHari . '/' . $bulanRomawi . '/' . $tahunAkhir . '/' . str_pad($urutan, 3, '0', STR_PAD_LEFT);

    // Loop through each nama_alat, jumlah, dan satuan
    foreach ($validatedData['nama_alat'] as $key => $value) {
        // Find the alat
        $alat = mdlalat::where('nama_alat', $validatedData['nama_alat'][$key])->first();

        if ($alat) {
            // Reduce the stock of the alat
            $alat->stok -= $validatedData['jumlah'][$key];
            $alat->save();

            // Create a new instance of mdlalatpjm for each set of data
            mdlalatpjm::create([
                'kode_alat_pinjam' => $kodeAlatPinjam, // Add kode_alat_pinjam here
                'nama_peminjam' => $validatedData['nama_peminjam'],
                'nama_alat' => $validatedData['nama_alat'][$key],
                'jumlah' => $validatedData['jumlah'][$key],
                'satuan' => $validatedData['satuan'][$key],
                'tempat_peminjaman' => $validatedData['tempat_peminjaman'],
                'tanggal_peminjaman' => $validatedData['tanggal_peminjaman'],
                'keperluan' => $validatedData['keperluan'],
                'google_id' => $validatedData['google_id'],
                'status' => $validatedData['status']
            ]);
        } else {
            return redirect()->route('alat')->with('error', 'Alat tidak ditemukan');
        }
    }

    return redirect()->route('alatpjm')->with('success', 'Peminjaman Alat Berhasil Ditambahkan');
}

// Fungsi untuk mengubah bulan dalam angka ke bulan Romawi
private function bulanRomawi($bulan)
{
    $bulanRomawi = [
        '01' => 'I',
        '02' => 'II',
        '03' => 'III',
        '04' => 'IV',
        '05' => 'V',
        '06' => 'VI',
        '07' => 'VII',
        '08' => 'VIII',
        '09' => 'IX',
        '10' => 'X',
        '11' => 'XI',
        '12' => 'XII',
    ];

    return $bulanRomawi[$bulan];
}

    
    public function delete(Request $request){
        $id = $request->input('id_alat_pinjam');
        $beli = mdlalatpjm::find($id);
        if(!$beli){
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        $beli->delete();

        return redirect()->route('alatpjm')->with('message', 'Data Berhasil Ditambahkan');
    }

    public function update(Request $request){
        $id = $request->input('id_alat_pinjam');
    
        // Temukan data berdasarkan ID
        $alat = mdlalatpjm::find($id);
    
        if(!$alat){
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    
        $validasidata = $request->validate([
            'nama_alat'=> 'required',
            'tempat_peminjaman'=> 'required',
            'jumlah'=> 'required|numeric',
            'satuan'=> 'required',
            'tanggal_peminjaman'=> 'required|date',
            'keperluan'=> 'required',
        ]);
    
        // Update data alat
        $alat->update($validasidata);
    
        return redirect()->route('alatpjm')->with('message', 'Data Berhasil Diperbarui');
    }
    public function alatkembali(Request $request){
        $id = $request->input('id_alat_pinjam');
        $google_id = $request->input('google_id');
        $jumlah = $request->input('jumlah');
    
        // Temukan data berdasarkan ID
        $alatPinjam = mdlalatpjm::find($id);
    
        if(!$alatPinjam){
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    
        // Validasi data yang diperlukan
        $validatedData = $request->validate([
            'jumlah' => 'required|numeric',
            'tanggal_kembali' => 'nullable|date_format:Y-m-d',
        ]);
    
        // Jika tanggal_kembali tidak ada dalam request, tetapkan tanggal hari ini
        $tanggalKembali = $request->input('tanggal_kembali', now()->format('Y-m-d'));
    
        // Ambil data alat dari tabel 'alat' dan 'bmn' berdasarkan 'nama_alat'
        $alat = mdlalat::where('nama_alat', $alatPinjam->nama_alat)->first();
    
        if(!$alat){
            return redirect()->route('alatpjm')->with('error', 'Alat tidak ditemukan dalam stok');
        }
    
        // Update stok alat berdasarkan jumlah yang dikembalikan
        if ($alat) {
            $alat->stok += $jumlah;
            $alat->save();
        }
    
        // Update data alat pinjam dengan mengurangi jumlah yang dikembalikan
        $alatPinjam->update([
            'jumlah' => $jumlah,
            'tanggal_kembali' => $tanggalKembali,
        ]);
    
        return redirect()->route('draftpinjammhs', ['google_id' => $google_id])->with('success', 'Stok Alat Berhasil Diperbarui');

    }
}
