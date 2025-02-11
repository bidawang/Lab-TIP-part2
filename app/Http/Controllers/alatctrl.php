<?php

namespace App\Http\Controllers;

use App\Models\mdlalat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
            'keterangan'=>'required',
            'foto_alat'=> 'required|image|mimes:jpeg,png,jpg,gif', // Atur validasi untuk jenis dan ukuran file gambar
        ]);
    
        $gambar = $request->file('foto_alat');
        $namaFile = uniqid() . '.' . $gambar->getClientOriginalExtension(); // Buat nama file unik
        $gambar->move(public_path('Foto Alat'), $namaFile); // Pindahkan file ke direktori yang ditentukan
    
        // Tambahkan nama file ke data yang akan disimpan di database
        $validasidata['foto_alat'] = $namaFile;
    
        mdlalat::create($validasidata);
        
        return redirect()->route('alat')->with('success', 'Data Berhasil Ditambahkan');
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

        return redirect()->route('alat')->with('danger', 'Data Berhasil Dihapus');
    }

    public function update(Request $request){
        $id = $request->input('id_alat');

        // Temukan data berdasarkan ID
        $alat = mdlalat::find($id);

        if(!$alat){
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $validasidata = $request->validate([
            'nama_alat'=> 'required',
            'stok'=> 'required',
            'satuan'=> 'required',
            'keterangan'=> 'required',
            'foto_alat'=> 'image|mimes:jpeg,png,jpg,gif', // Atur validasi untuk jenis dan ukuran file gambar
        ]);

        // Jika ada file gambar yang diunggah
        if($request->hasFile('foto_alat')) {
            // Hapus foto lama dari direktori
            $fotoPath = public_path('Foto Alat/'.$alat->foto_alat);
            if(File::exists($fotoPath)) {
                File::delete($fotoPath);
            }

            // Upload foto baru
            $gambar = $request->file('foto_alat');
            $namaFile = uniqid() . '.' . $gambar->getClientOriginalExtension(); // Buat nama file unik
            $gambar->move(public_path('Foto Alat'), $namaFile); // Pindahkan file ke direktori yang ditentukan

            // Tambahkan nama file baru ke data yang akan disimpan di database
            $validasidata['foto_alat'] = $namaFile;
        }

        // Update data alat
        $alat->update($validasidata);

        return redirect()->route('alat')->with('warning', 'Data Berhasil Diperbarui');
    }
//     public function rusaktus(Request $request)
// {
//     $id = $request->input('id_alat');
//     $mdlakun = mdlalat::find($id);
    
//     $valdat = $request->validate([
//         'status' => 'required'    ]);

//     $mdlakun->update($valdat);

//     return redirect()->route('akun')->with('message', 'Data Berhasil Diperbarui');
// }

public function getSatuan($nama_alat)
{
    $alat = mdlalat::where('nama_alat', $nama_alat)->first();
    if ($alat) {
        return response()->json(['satuan' => $alat->satuan]);
    } else {
        return response()->json(['satuan' => ''], 404);
    }
}

}

    

