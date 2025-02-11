<?php

namespace App\Http\Controllers;

use App\Models\mdlbahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class bahanctrl extends Controller
{
    public function index(){
        $bahan = mdlbahan::all();
        return view('Laboran/Bahan.bahan', ['bahan'=>$bahan]);
    }

    public function insert(Request $request){
        

        $validasidata = $request->validate([
            'nama_bahan'=> 'required',
            'stok'=> 'required',
            'satuan'=> 'required',
            'keterangan'=>'required',
            'foto_bahan'=> 'required|image|mimes:jpeg,png,jpg,gif',
            'google_id'=> 'required'// Atur validasi untuk jenis dan ukuran file gambar
        ]);
    
        $gambar = $request->file('foto_bahan');
        $namaFile = uniqid() . '.' . $gambar->getClientOriginalExtension(); // Buat nama file unik
        $gambar->move(public_path('Foto Bahan'), $namaFile); // Pindahkan file ke direktori yang ditentukan
    
        // Tambahkan nama file ke data yang akan disimpan di database
        $validasidata['foto_bahan'] = $namaFile;
    
        mdlbahan::create($validasidata);
        
        return redirect()->route('bahan')->with('success', 'Data Berhasil Ditambahkan !!!');
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

        return redirect()->route('bahan')->with('danger', 'Data Berhasil DIhapus !!!');
    }

    public function update(Request $request){
        $id = $request->input('id_bahan');

        // Temukan data berdasarkan ID
        $bahan = mdlbahan::find($id);

        if(!$bahan){
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $validasidata = $request->validate([
            'nama_bahan'=> 'required',
            'stok'=> 'required',
            'satuan'=> 'required',
            'status'=> 'required',
            'keterangan'=> 'required',
            'foto_bahan'=> 'image|mimes:jpeg,png,jpg,gif', // Atur validasi untuk jenis dan ukuran file gambar
        ]);

        // Jika ada file gambar yang diunggah
        if($request->hasFile('foto_bahan')) {
            // Hapus foto lama dari direktori
            $fotoPath = public_path('Foto Bahan/'.$bahan->foto_bahan);
            if(File::exists($fotoPath)) {
                File::delete($fotoPath);
            }

            // Upload foto baru
            $gambar = $request->file('foto_bahan');
            $namaFile = uniqid() . '.' . $gambar->getClientOriginalExtension(); // Buat nama file unik
            $gambar->move(public_path('Foto Bahan'), $namaFile); // Pindahkan file ke direktori yang ditentukan

            // Tambahkan nama file baru ke data yang akan disimpan di database
            $validasidata['foto_bahan'] = $namaFile;
        }

        // Update data bahan
        $bahan->update($validasidata);

        return redirect()->route('bahan')->with('warning', 'Data Berhasil Diperbarui !!!');
    }

    public function getBahanSatuan($nama_bahan) {
        $bahan = Bahan::where('nama_bahan', $nama_bahan)->first();
    
        if ($bahan) {
            return response()->json(['satuan' => $bahan->satuan]);
        } else {
            return response()->json(['satuan' => '']);
        }
    }
}
