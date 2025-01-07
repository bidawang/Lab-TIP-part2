<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\mdlbahan;
use App\Models\mdlbahanuse;
use Illuminate\Http\Request;

class bahanusectrl extends Controller
{
    public function index(){
        $bahanpjm = mdlbahanuse::all();
        
        return view('Laboran/Bahan Pakai.bahanpakai', ['bahan_pakai'=>$bahanpjm]);
    }

    
    public function print() {
        $endDate = Carbon::now()->toDateString();
        $startDate = Carbon::now()->subDays(30)->toDateString();
        $bahan = mdlbahan::all();
        $bahanpjm = mdlbahanuse::whereBetween('created_at', [$startDate, $endDate])->get();
        return view('Laboran/Bahan Pakai.printbahpak', compact('bahanpjm','bahan', 'startDate', 'endDate'));
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
            $bahanpjm = mdlbahanuse::whereBetween('created_at', [$startDate, $endDateFormatted])->get();
            $bahan = mdlbahan::all();
            
            // Kirim data hasil pencarian ke view
            return view('Laboran/Bahan Pakai.printbahpak', compact('bahanpjm','bahan', 'startDate', 'endDate'));
        } catch (\Exception $e) {
            // Handle error jika terjadi kesalahan
            return redirect()->back()->withErrors('Terjadi kesalahan saat melakukan pencarian.');
        }
    }


    public function viewtbahan(){
        $bahan = mdlbahan::all();
        return view('Laboran/Bahan Pakai.tambahbahanpakai', compact('bahan'));
    }
    
    public function insert(Request $request)
{
    $validatedData = $request->validate([
        'nama_bahan.*' => 'required', // Making nama_bahan an array
        'jumlah.*' => 'required', // Making jumlah an array
        'satuan.*' => 'required', // Making satuan an array
        'keperluan' => 'required',
        'nama_pemakai' => 'required',
        'tanggal_pemakaian' => 'required',
        'google_id' => 'required',
        'status' => 'required'
    ]);

    // Loop through each nama_bahan, jumlah, and satuan
    foreach ($validatedData['nama_bahan'] as $key => $value) {
        // Find the bahan
        $bahan = mdlbahan::where('nama_bahan', $validatedData['nama_bahan'][$key])->first();
        if ($bahan) {
            // Reduce the stock of the bahan
            $bahan->stok -= $validatedData['jumlah'][$key];
            $bahan->save();

            // Create a new instance of mdlbahanuse for each set of data
            mdlbahanuse::create([
                'nama_bahan' => $validatedData['nama_bahan'][$key],
                'jumlah' => $validatedData['jumlah'][$key],
                'satuan' => $validatedData['satuan'][$key],
                'keperluan' => $validatedData['keperluan'],
                'nama_pemakai' => $validatedData['nama_pemakai'],
                'tanggal_pemakaian' => $validatedData['tanggal_pemakaian'],
                'google_id' => $validatedData['google_id'],
                'status' => $validatedData['status']
            ]);
        } else {
            return redirect()->route('bahan')->with('error', 'Bahan tidak ditemukan');
        }
    }

    return redirect()->route('bahan_pakai')->with('success', 'Data Berhasil Ditambahkan');
}


    public function delete(Request $request){
        $id = $request->input('id_bahan_pakai');
        $beli = mdlbahanuse::find($id);

        if(!$beli){
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Hapus data dari database
        $beli->delete();

        return redirect()->route('bahan_pakai')->with('message', 'Data Berhasil Ditambahkan');
    }

    
    public function update(Request $request){
        $id = $request->input('id_bahan_pakai');
    
        // Temukan data berdasarkan ID
        $ruang = mdlbahanuse::find($id);
    
        if(!$ruang){
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    
        $validasidata = $request->validate([
            'nama_bahan'=> 'required',
            'jumlah'=> 'required',
            'keperluan'=> 'required',
        ]);
    
        // Update data ruangan
        $ruang->update($validasidata);
    
        return redirect()->route('bahan_pakai')->with('message', 'Data Berhasil Diperbarui');
    }
}
