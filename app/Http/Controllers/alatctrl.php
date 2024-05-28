<?php

namespace App\Http\Controllers;

use App\Models\mdlalat;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class alatctrl extends Controller
{
    public function index(){
        $alat = mdlalat::all();
        return view('Laboran/alat.alat', ['alat'=>$alat]);
    }

    public function insert(Request $request){

        $validasidata = $request->validate([
            'nama_alat'=> 'required',
            'stok'=> 'required',
            'satuan'=> 'required',
            'foto_alat'=> 'required|image|mimes:jpeg,png,jpg,gif', // Atur validasi untuk jenis dan ukuran file gambar
        ]);
    
        $gambar = $request->file('foto_alat');
        $namaFile = uniqid() . '.' . $gambar->getClientOriginalExtension(); // Buat nama file unik
        $gambar->move(public_path('Foto Alat'), $namaFile); // Pindahkan file ke direktori yang ditentukan
    
        // Tambahkan nama file ke data yang akan disimpan di database
        $validasidata['foto_alat'] = $namaFile;
    
        mdlalat::create($validasidata);
        
        return response()->json(['message' => 'Data Berhasil Ditambahkan'], 200);
    }

    public function delete(Request $request){
        $id = $request->input('id_alat');

        // Temukan data berdasarkan ID
        $beli = mdlalat::find($id);

        if(!$beli){
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Hapus foto dari direktori
        $fotoPath = public_path('Foto Alat/'.$beli->foto_alat);
        if(File::exists($fotoPath)) {
            File::delete($fotoPath);
        }

        // Hapus data dari database
        $beli->delete();

        return response()->json(['message' => 'Data Berhasil Dihapus'], 200);
    }
    

}
