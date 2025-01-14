<?php

namespace App\Http\Controllers;

use App\Models\mdlakun;
use App\Models\User;
use App\Models\mdlalatpjm;
use App\Models\mdlbahanuse;
use App\Models\mdlruangpjm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class heafoctrl extends Controller
{
    public function indjam(Request $request)
{
    $alat_pinjam = mdlalatpjm::query();
    $bahan_pakai = mdlbahanuse::query();
    $pinjam_ruangan = mdlruangpjm::query();

    // Filter berdasarkan created_at jika request parameter created_at diberikan
    if ($request->has('created_at')) {
        $alat_pinjam->whereDate('created_at', $request->created_at);
        $bahan_pakai->whereDate('created_at', $request->created_at);
        $pinjam_ruangan->whereDate('created_at', $request->created_at);
    }

    $alat_pinjam = $alat_pinjam->get();
    $bahan_pakai = $bahan_pakai->get();
    $pinjam_ruangan = $pinjam_ruangan->get();

    // Mengirimkan data dari tiga model ke tampilan
    return view('Laboran/draft.drafalat', [
        'alat_pinjam' => $alat_pinjam,
        'bahan_pakai' => $bahan_pakai,
        'pinjam_ruangan' => $pinjam_ruangan,
    ]);
}

    public function indjammhs(Request $request)
{
    // Mengambil google_id dari request
    $google_id = $request->input('google_id');
    // Inisialisasi query untuk masing-masing model
    $alat_pinjam = mdlalatpjm::where('google_id', $google_id);
    $bahan_pakai = mdlbahanuse::where('google_id', $google_id);
    $pinjam_ruangan = mdlruangpjm::where('google_id', $google_id);

    // Filter berdasarkan created_at jika request parameter created_at diberikan
    if ($request->filled('created_at')) {
        $created_at = $request->input('created_at');
        $alat_pinjam->whereDate('created_at', $created_at);
        $bahan_pakai->whereDate('created_at', $created_at);
        $pinjam_ruangan->whereDate('created_at', $created_at);
    }

    // Ambil data menggunakan metode get() untuk masing-masing query
    $alat_pinjam = $alat_pinjam->get();
    $bahan_pakai = $bahan_pakai->get();
    $pinjam_ruangan = $pinjam_ruangan->get();

    $user = User::where('google_id', $google_id)->first();

    // Mengirimkan data dari tiga model ke tampilan
    return view('Laboran/draft/personal.drafalat', [
        'alat_pinjam' => $alat_pinjam,
        'bahan_pakai' => $bahan_pakai,
        'pinjam_ruangan' => $pinjam_ruangan,
        'email' => $user ? $user->email : null,
    ]);
}

public function indexDraft(Request $request)
{
    $alat_pinjam = MdlAlatPjm::query();
    $bahan_pakai = MdlBahanUse::query();
    $pinjam_ruangan = MdlRuangPjm::query();

    // Filter berdasarkan created_at jika request parameter created_at diberikan
    if ($request->has('created_at')) {
        $alat_pinjam->whereDate('created_at', $request->created_at);
        $bahan_pakai->whereDate('created_at', $request->created_at);
        $pinjam_ruangan->whereDate('created_at', $request->created_at);
    }

    $alat_pinjam = $alat_pinjam->get();
    $bahan_pakai = $bahan_pakai->get();
    $pinjam_ruangan = $pinjam_ruangan->get();

    return view('Laboran.draft.drafalat', compact('alat_pinjam', 'bahan_pakai', 'pinjam_ruangan'));
}

    public function statbah(Request $request){
        
       $id = $request->input('id_bahan_pakai');
       $mdlakun = mdlbahanuse::find($id);
       
       $valdat = $request->validate([
           'status' => 'required'
       ]);
   
       $mdlakun->update($valdat);
   
       return redirect()->route('draftpinjam')->with('message', 'Data Berhasil Diperbarui');
    }
    public function statbahmhs(Request $request){
        
       $id = $request->input('id_bahan_pakai');
       $mdlakun = mdlbahanuse::find($id);
       
       $valdat = $request->validate([
           'status' => 'required',
           'google_id' => 'required',

       ]);
       $google_id = $valdat['google_id'];
       $mdlakun->update($valdat);
       return redirect()->route('draftpinjammhs', ['google_id' => $google_id])->with('success', 'Stok Bahan Berhasil Diperbarui');

    }

    public function stalat(Request $request){
        
       $id = $request->input('id_alat_pinjam');
       $mdlakun = mdlalatpjm::find($id);
       
       $valdat = $request->validate([
           'status' => 'required'
       ]);
       
       $mdlakun->update($valdat);
   
       return redirect()->route('draftpinjam')->with('message', 'Data Berhasil Diperbarui');
    }
    public function mhsstat(Request $request){
       $id = $request->input('id_alat_pinjam');
       $mdlakun = mdlalatpjm::find($id);
       
       $valdat = $request->validate([
           'status' => 'required',
           'google_id' => 'required'
       ]);
       $google_id = $valdat['google_id'];
       $mdlakun->update($valdat);
       return redirect()->route('draftpinjammhs', ['google_id' => $google_id])->with('success', 'Status Berhasil Diubah !!!');

    }

    public function riwayat()
{
    // Mengambil data alat, bahan, dan ruangan
    $alat_pinjam = mdlalatpjm::all();
    $bahan_pakai = mdlbahanuse::all();

    // Melakukan join antara mdlruangpjm dan mdlakun untuk mendapatkan email
    $pinjam_ruangan = mdlruangpjm::join('users', function ($join) {
        $join->on(DB::raw('BINARY pinjam_ruangan.google_id'), '=', DB::raw('BINARY users.google_id'));
    })
    ->select('pinjam_ruangan.*', 'users.email') // Select email field from users
    ->get();
    // Grouping data by 'nama_peminjam' for alat pinjam
    $groupedAlatPinjam = $alat_pinjam->where('tanggal_kembali', !NULL)->groupBy('nama_peminjam');

    // Grouping data by 'nama_pemakai' for bahan pakai
    $groupedBahanPakai = $bahan_pakai->where('status', 'Disetujui')->groupBy('nama_pemakai');

    // Grouping data by 'nama_peminjam' for pinjam ruangan
    $groupedPinjamRuangan = $pinjam_ruangan->where('status', 'Disetujui')->groupBy('created_by');

    // Mengirimkan data ke view
    return view('Laboran/draft.riwayat', [
        'groupedAlatPinjam' => $groupedAlatPinjam,
        'groupedBahanPakai' => $groupedBahanPakai,
        'groupedPinjamRuangan' => $groupedPinjamRuangan,
        'namafgid' => $pinjam_ruangan
    ]);
}


    
}
