<?php

namespace App\Http\Controllers;

use App\Models\mdlruang;
use App\Models\mdlruangpjm;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ruangpjmctrl extends Controller
{
    public function index(){
        $ruangpjm= mdlruangpjm::all();
        return view('Laboran/Ruang Pinjam.ruangpjm', ['ruang_pinjam'=>$ruangpjm]);
    }

    public function truangpjm() {
        $ruangan = mdlruang::all();
        return view('Laboran/Ruang Pinjam.tambahruangpjm',compact('ruangan'));
    }
    
    public function insert(Request $request) {
        $validasidata = $request->validate([
            'keperluan'=> 'required',
            'nama_peminjam'=> 'required',
            'tanggal_peminjaman'=> 'required',
            'jam_mulai'=> 'required',
            'jam_selesai'=> 'required',
            'mata_kuliah'=> 'required',
            'status'=> 'required',
            'google_id'=>'required',
            'nama_ruangan'=> 'required',
            'tipe_peminjaman'=> 'required',
        ]);
    mdlruangpjm::create($validasidata);

    return redirect()->route('ruangpjm')->with('message', 'Surat Berhasil Ditambahkan');

}
public function update(Request $request){
    $id = $request->input('id_pinjam_ruangan');

    // Temukan data berdasarkan ID
    $ruang = mdlruangpjm::find($id);

    if(!$ruang){
        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    }

    $validasidata = $request->validate([
                'keperluan'=> 'required',
            'nama_peminjam'=> 'required',
            'tanggal_peminjaman'=> 'required',
            'jam_mulai'=> 'required',
            'jam_selesai'=> 'required',
            'mata_kuliah'=> 'required',
            'status'=> 'required',
            'nama_ruangan'=> 'required',
    ]);

    // Update data ruangan
    $ruang->update($validasidata);

    return redirect()->route('ruangpjm')->with('message', 'Data Berhasil Diperbarui');
}
public function delete(Request $request){
    $id = $request->input('id_pinjam_ruangan');

    // Temukan data berdasarkan ID
    $beli = mdlruangpjm::find($id);

    if(!$beli){
        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    } 

    // Hapus data dari database
    $beli->delete();

    return redirect()->route('ruangpjm')->with('message', 'Data Berhasil Ditambahkan');
}

public function statusruang(Request $request){
    $id = $request->input('id_pinjam_ruangan');
    $mdlakun = mdlruangpjm::find($id);
    
    $valdat = $request->validate([
        'status' => 'required',
        'google_id' => 'required'
    ]);
    $google_id = $valdat['google_id'];
    $mdlakun->update($valdat);
    return redirect()->route('draftpinjammhs', ['google_id' => $google_id])->with('success', 'Ruangan Berhasil Diperbarui');

}

public function print() {
    $endDate = Carbon::now()->toDateString();
    $startDate = Carbon::now()->subDays(30)->toDateString();
    $ruangpjm = mdlruangpjm::whereBetween('created_at', [$startDate, $endDate])->get();
    return view('Laboran/Ruang Pinjam.printsurat', compact('ruangpjm', 'startDate', 'endDate'));
}

public function filter(Request $request) {
    $request->validate([
        'tanggal' => 'required|date',
    ]);

    $tanggal = $request->input('tanggal');
    $ruangpjm = mdlruangpjm::whereDate('tanggal_peminjaman', $tanggal)->get();

    return view('Laboran/Ruang Pinjam.printsurat', compact('ruangpjm', 'tanggal'));
}
}