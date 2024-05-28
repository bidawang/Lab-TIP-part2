<?php

namespace App\Http\Controllers;

use App\Models\mdlruang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ruangctrl extends Controller
{
    public function index(){
        $ruang = mdlruang::all();
        return view('Laboran/ruangan.ruang', ['ruang'=>$ruang]);
    }

    public function insert(Request $request){

        $validasidata = $request->validate([
            'nama_ruangan'=> 'required',
            'lantai'=> 'required',
            'gedung'=> 'required',
            'laboran'=> 'required',
            'foto_ruangan'=> 'required|image|mimes:jpeg,png,jpg,gif', // Atur validasi untuk jenis dan ukuran file gambar
        ]);
    
        $gambar = $request->file('foto_ruangan');
        $namaFile = uniqid() . '.' . $gambar->getClientOriginalExtension(); // Buat nama file unik
        $gambar->move(public_path('Foto Ruang'), $namaFile); // Pindahkan file ke direktori yang ditentukan
    
        // Tambahkan nama file ke data yang akan disimpan di database
        $validasidata['foto_ruangan'] = $namaFile;
    
        mdlruang::create($validasidata);
        
        return redirect()->route('ruang')->with('message', 'Data Berhasil Ditambahkan');
    }
    public function delete(Request $request){
        $id = $request->input('id_ruangan');

        // Temukan data berdasarkan ID
        $beli = mdlruang::find($id);

        if(!$beli){
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Hapus foto dari direktori
        $fotoPath = public_path('Foto Ruang/'.$beli->foto_ruangan);
        if(File::exists($fotoPath)) {
            File::delete($fotoPath);
        }

        // Hapus data dari database
        $beli->delete();

        return redirect()->route('ruang')->with('message', 'Data Berhasil Ditambahkan');
    }
}
