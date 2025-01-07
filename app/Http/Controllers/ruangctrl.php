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
            'google_id'=>'required',
            'nama_ruangan'=> 'required',
            'lantai'=> 'required',
            'gedung'=> 'required',
            'google_id' =>'required',
            'keterangan'=>'required',
            'Laboran'=> 'required',
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

        return redirect()->route('ruang')->with('danger', 'Data Berhasil Dihapus');
    }

    public function update(Request $request){
        $id = $request->input('id_ruangan');
    
        // Temukan data berdasarkan ID
        $ruang = mdlruang::find($id);
    
        if(!$ruang){
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    
        $validasidata = $request->validate([
            'nama_ruangan'=> 'required',
            'lantai'=> 'required',
            'gedung'=> 'required',
            'keterangan'=> 'required',
            'Laboran'=> 'required',
            'foto_ruangan'=> 'image|mimes:jpeg,png,jpg,gif', // Atur validasi untuk jenis dan ukuran file gambar
        ]);
    
        // Jika ada file gambar yang diunggah
        if($request->hasFile('foto_ruangan')) {
            // Hapus foto lama dari direktori
            $fotoPath = public_path('Foto Ruang/'.$ruang->foto_ruangan);
            if(File::exists($fotoPath)) {
                File::delete($fotoPath);
            }
    
            // Upload foto baru
            $gambar = $request->file('foto_ruangan');
            $namaFile = uniqid() . '.' . $gambar->getClientOriginalExtension(); // Buat nama file unik
            $gambar->move(public_path('Foto Ruang'), $namaFile); // Pindahkan file ke direktori yang ditentukan
    
            // Tambahkan nama file baru ke data yang akan disimpan di database
            $validasidata['foto_ruangan'] = $namaFile;
        }
    
        // Update data ruangan
        $ruang->update($validasidata);
    
        return redirect()->route('ruang')->with('warning', 'Data Berhasil Diperbarui');   
    }
}
