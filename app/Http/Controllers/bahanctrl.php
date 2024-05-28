<?php

namespace App\Http\Controllers;

use App\Models\mdlbahan;
use Illuminate\Http\Request;

class bahanctrl extends Controller
{
    public function index(){
        $bahan = mdlbahan::all();
        return view('Laboran/bahan.bahan', ['bahan'=>$bahan]);
    }

    public function insert(Request $request){

        $validasidata = $request->validate([
            'nama_bahan'=> 'required',
            'stok'=> 'required',
            'satuan'=> 'required',
            'foto_bahan'=> 'required|image|mimes:jpeg,png,jpg,gif', // Atur validasi untuk jenis dan ukuran file gambar
        ]);
    
        $gambar = $request->file('foto_bahan');
        $namaFile = uniqid() . '.' . $gambar->getClientOriginalExtension(); // Buat nama file unik
        $gambar->move(public_path('Foto Bahan'), $namaFile); // Pindahkan file ke direktori yang ditentukan
    
        // Tambahkan nama file ke data yang akan disimpan di database
        $validasidata['foto_bahan'] = $namaFile;
    
        mdlbahan::create($validasidata);
        
        return response()->json(['message' => 'Data Berhasil Ditambahkan'], 200);
    }

    public function delete(Request $request){
        $id = $request->input('id_bahan');

        // Temukan data berdasarkan ID
        $beli = mdlbahan::find($id);

        if(!$beli){
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Hapus foto dari direktori
        $fotoPath = public_path('Foto Bahan/'.$beli->foto_bahan);
        if(File::exists($fotoPath)) {
            File::delete($fotoPath);
        }

        // Hapus data dari database
        $beli->delete();

        return response()->json(['message' => 'Data Berhasil Dihapus'], 200);
    }
}
