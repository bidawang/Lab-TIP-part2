<?php

namespace App\Http\Controllers;

use App\Models\mblbmn;
use Illuminate\Http\Request;

class bmnctrl extends Controller
{
    public function index(){
        $alat = mblbmn::all();
        return view('Laboran/alat.tambahbmn', ['alat_bmn'=>$alat]);
    }
    public function insert(Request $request)
    {
        $validasidata = $request->validate([
            'nama_alat' => 'required',
            'merk' => 'required',
            'stok'=>'required',
            'satuan'=>'required',
            'google_id'=>'required',
            'kode_barang' => 'required',
            'kondisi_barang' => 'required',
            'keterangan' => 'required',
            'foto_barang' => 'required|image|mimes:jpeg,png,jpg,gif', // Atur validasi untuk jenis dan ukuran file gambar
            'foto_kode' => 'required|image|mimes:jpeg,png,jpg,gif', // Atur validasi untuk jenis dan ukuran file gambar
        ]);

        // Handle the foto_barang upload
        $fotoBarang = $request->file('foto_barang');
        $namaFileBarang = uniqid() . '_barang.' . $fotoBarang->getClientOriginalExtension(); // Buat nama file unik
        $fotoBarang->move(public_path('Foto Barang'), $namaFileBarang); // Pindahkan file ke direktori yang ditentukan

        // Handle the foto_kode upload
        $fotoKode = $request->file('foto_kode');
        $namaFileKode = uniqid() . '_kode.' . $fotoKode->getClientOriginalExtension(); // Buat nama file unik
        $fotoKode->move(public_path('Foto Kode'), $namaFileKode); // Pindahkan file ke direktori yang ditentukan

        // Tambahkan nama file ke data yang akan disimpan di database
        $validasidata['foto_barang'] = $namaFileBarang;
        $validasidata['foto_kode'] = $namaFileKode;

        mblbmn::create($validasidata);

        return redirect()->route('alat')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function update(Request $request, $id_bmn)
{
    // Temukan data berdasarkan ID
    $alat = mblbmn::findOrFail($id_bmn);

    $validasidata = $request->validate([
        'nama_alat' => 'required',
        'merk' => 'required',
        'kondisi_barang' => 'required',
        'keterangan' => 'required',
        'foto_barang' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        'foto_kode' => 'nullable|image|mimes:jpeg,png,jpg,gif',
    ]);

    if ($request->hasFile('foto_barang')) {
        $fotoBarang = $request->file('foto_barang');
        $namaFileBarang = uniqid() . '_barang.' . $fotoBarang->getClientOriginalExtension();
        $fotoBarang->move(public_path('Foto Barang'), $namaFileBarang);
        $validasidata['foto_barang'] = $namaFileBarang;

        if (file_exists(public_path('Foto Barang/' . $alat->foto_barang))) {
            unlink(public_path('Foto Barang/' . $alat->foto_barang));
        }
    }

    if ($request->hasFile('foto_kode')) {
        $fotoKode = $request->file('foto_kode');
        $namaFileKode = uniqid() . '_kode.' . $fotoKode->getClientOriginalExtension();
        $fotoKode->move(public_path('Foto Kode'), $namaFileKode);
        $validasidata['foto_kode'] = $namaFileKode;

        if (file_exists(public_path('Foto Kode/' . $alat->foto_kode))) {
            unlink(public_path('Foto Kode/' . $alat->foto_kode));
        }
    }

    $alat->update($validasidata);

    return redirect()->route('alat')->with('warning', 'Data Berhasil Diperbarui');
}


public function delete(Request $request)
{
    $id = $request->input('id_bmn');

    // Ambil data berdasarkan ID
    $data = mblbmn::findOrFail($id);

    // Hapus foto barang jika ada
    if (public_path('Foto Barang/' . $data->foto_barang)) {
        unlink(public_path('Foto Barang/' . $data->foto_barang));
    }

    // Hapus foto kode jika ada
    if (public_path('Foto Kode/' . $data->foto_kode)) {
        unlink(public_path('Foto Kode/' . $data->foto_kode));
    }

    // Hapus data dari database
    $data->delete();

    return redirect()->route('alat')->with('danger', 'Data Berhasil Dihapus');
}
}
