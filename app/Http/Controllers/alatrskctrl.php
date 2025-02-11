<?php

namespace App\Http\Controllers;

use App\Models\mblbmn;
use App\Models\mdlalat;
use App\Models\mdlalatrsk;
use Illuminate\Http\Request;
use Log;

class alatrskctrl extends Controller
{

    public function index()
    {
        // Eager load both 'alat' and 'alat_bmn' relationships to optimize queries
        $alatRusak = mdlalatrsk::with(['alat', 'alat_bmn'])->get();
    
        // Pass the data to the view
        return view('Laboran/alat.alatucak', ['alat_rusak' => $alatRusak]);
    }
    
    public function riwayat()
    {
        // Eager load the 'alat' relationship to optimize queries
        $alatRusak = mdlalatrsk::with('alat')->get();
    
        // Pass the data to the view
        return view('Laboran/alat.riwayatucak', ['alat_rusak' => $alatRusak]);
    }
    

    public function insert(Request $request)
    {
        // Validasi data
        $validasidata = $request->validate([
            'penanggungjawab' => 'required',
            'jumlah' => 'required|integer|min:1',
            'penyebab_kerusakan' => 'required',
            'keterangan' => 'required',
            'tingkat_kerusakan' => 'required',
            'google_id' => 'required',
            'id_alat' => 'required|exists:alat,id_alat' // Validasi id_alat harus ada di tabel alat
        ]);

        $validasidata['riwayat'] = $validasidata['jumlah'];

        // Tambahkan data alat rusak
        mdlalatrsk::create($validasidata);

        // Kurangi stok alat berdasarkan jumlah alat rusak
        $alat = mdlalat::find($validasidata['id_alat']);
        if ($alat) {
            $alat->stok -= $validasidata['jumlah'];
            $alat->save();
        } else {
            return redirect()->route('alat')->with('error', 'Alat tidak ditemukan');
        }

        return redirect()->route('alat.ucak')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function insertbmn(Request $request)
    {
        // Validasi data
        $validasidata = $request->validate([
            'penanggungjawab' => 'required',
            'jumlah' => 'required|integer|min:1',
            'penyebab_kerusakan' => 'required',
            'keterangan' => 'required',
            'tingkat_kerusakan' => 'required',
            'google_id' => 'required',
            'kode_barang' => 'required',
            'id_bmn' => 'required|exists:alat_bmn,id_bmn' // Validasi id_bmn harus ada di tabel alat_bmn
        ]);

        $validasidata['riwayat'] = $validasidata['jumlah'];

        // Tambahkan data alat rusak
        mdlalatrsk::create($validasidata);

        // Kurangi stok alat berdasarkan jumlah alat rusak
        $alat = mblbmn::find($validasidata['id_bmn']);
        if ($alat) {
            $alat->stok -= $validasidata['jumlah'];
            $alat->save();
        } else {
            return redirect()->route('alat')->with('error', 'Alat tidak ditemukan');
        }

        return redirect()->route('alat.ucak')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function upbaik(Request $request)
    {
        $idAlatRusak = $request->input('id_alat_rusak');
    
        // Find alat rusak data by ID
        $alatRusak = mdlalatrsk::find($idAlatRusak);
    
        if (!$alatRusak) {
            return response()->json(['message' => 'Data alat rusak tidak ditemukan'], 404);
        }
    
        $validasidata = $request->validate([
            'id_alat_rusak' => 'required',
            'id_alat' => 'sometimes|required_without:id_bmn',
            'id_bmn' => 'sometimes|required_without:id_alat',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'required|string',
            'google_id' => 'required|string'
        ]);
    
        // Calculate updated quantity
        $updatedQuantity = $alatRusak->jumlah - $validasidata['jumlah'];
    
        if ($updatedQuantity < 0) {
            return response()->json(['message' => 'Jumlah perbaikan tidak bisa lebih besar dari jumlah kerusakan'], 400);
        }
    
        // Update alat rusak data
        $alatRusak->update([
            'jumlah' => $updatedQuantity,
            'keterangan' => $validasidata['keterangan'],
            'google_id' => $validasidata['google_id']
        ]);
    
        // Determine whether to update alat or alat_bmn based on the presence of id_alat or id_bmn
        if (isset($validasidata['id_alat'])) {
            Log::info('Updating alat with ID: ' . $validasidata['id_alat']);
            $alat = mdlalat::find($validasidata['id_alat']);
            if (!$alat) {
                return response()->json(['message' => 'Data alat tidak ditemukan'], 404);
            }
            $alat->update([
                'stok' => $alat->stok + $validasidata['jumlah'] // Increase the stock
            ]);
        } elseif (isset($validasidata['id_bmn'])) {
            Log::info('Updating alat BMN with ID: ' . $validasidata['id_bmn']);
            $alatBmn = mblbmn::find($validasidata['id_bmn']);
            if (!$alatBmn) {
                return response()->json(['message' => 'Data alat BMN tidak ditemukan'], 404);
            }
            $alatBmn->update([
                'stok' => $alatBmn->stok + $validasidata['jumlah'] // Increase the stock
            ]);
        } else {
            return response()->json(['message' => 'Either id_alat or id_bmn must be provided'], 400);
        }
    
        return redirect()->route('alat.ucak')->with('warning', 'Stok Berhasil Diperbarui');
    }
}
