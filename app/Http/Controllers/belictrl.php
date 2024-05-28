<?php

namespace App\Http\Controllers;

use App\Models\mdlalat;
use App\Models\mdlbeli;
use App\Models\mdlbahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class belictrl extends Controller
{
    public function index(){
        $beli = mdlbeli::all();
        return view('Laboran/pembelian.beli', ['beli'=>$beli]);
    }

    public function insert(Request $request) {
        $validasidata = $request->validate([
            'nama_barang' => 'required',
            'nama_toko' => 'required',
            'harga' => 'required',
            'jenis' => 'required',
            'satuan' => 'required',
            'jumlah' => 'required',
            'keterangan' => 'required',
            'foto_pembelian' => 'required|image|mimes:jpeg,png,jpg,gif', // Atur validasi untuk jenis dan ukuran file gambar
        ]);
        $gambar = $request->file('foto_pembelian');
        $namaFile = uniqid() . '.' . $gambar->getClientOriginalExtension(); // Buat nama file unik

        // Tambahkan nama file ke data yang akan disimpan di database
        $validasidata['foto_pembelian'] = $namaFile;
    
        mdlbeli::create($validasidata);
    
        if ($validasidata['jenis'] == 'bahan') {
            // Cari bahan berdasarkan nama bahan
            $bahan = mdlbahan::where('nama_bahan', $validasidata['nama_barang'])->first();
        
            if ($bahan) {
                // Jika bahan sudah ada, tambahkan stok
                $bahan->jumlah += $validasidata['jumlah'];
                $bahan->save();
            } else {
                // Jika bahan belum ada, insert data bahan
                $valbahan = [
                    'nama_bahan' => $validasidata['nama_barang'],
                    'satuan' => $validasidata['satuan'],
                    'stok' => $validasidata['jumlah'],
                    'foto_bahan' => $namaFile, // Gunakan nama file yang sama
                ];
                mdlbahan::create($valbahan);
            }
        } elseif ($validasidata['jenis'] == 'alat') {
            // Cari alat berdasarkan nama alat
            $alat = mdlalat::where('nama_alat', $validasidata['nama_barang'])->first();
        
            if ($alat) {
                // Jika alat sudah ada, tambahkan stok
                $alat->jumlah += $validasidata['jumlah'];
                $alat->save();
            } else {
                // Jika alat belum ada, insert data alat
                $valalat = [
                    'nama_alat' => $validasidata['nama_barang'],
                    'satuan' => $validasidata['satuan'],
                    'stok' => $validasidata['jumlah'],
                    'foto_alat' => $namaFile, // Gunakan nama file yang sama
                ];
                mdlalat::create($valalat);
            }
        }

    // MASIH SALAH LOGILA NYA
        if ($validasidata['jenis'] == 'bahan') {
            $folderTujuan = public_path('Foto Bahan');
        } elseif ($validasidata['jenis'] == 'alat') {
            $folderTujuan = public_path('Foto Alat');
        }
        $gambar->move($folderTujuan, $namaFile); // Pindahkan file ke direktori yang ditentukan
        $folderTambahan = public_path('Foto Beli');
        copy($folderTujuan . '/' . $namaFile, $folderTambahan . '/' . $namaFile);

        
        return redirect()->route('beli')->with('message', 'Data Berhasil Ditambahkan');
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
}
