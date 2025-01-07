<?php

namespace App\Http\Controllers;

use App\Models\mdlakun;
use Illuminate\Http\Request;

class akunctrl extends Controller
{
    public function index(){
        $akun = mdlakun::all();
        return view('Laboran/Daftar.akun', ['akun'=>$akun]);
    }

    public function daftarakun(){
        $akun = mdlakun::all();
        return view('Laboran/akun.akun', ['akun'=>$akun]);
    }

    public function profile(){

        $user = auth()->user();

        return view('Laboran/Daftar.detailakun', ['user' => $user]);

    }

    public function update(Request $request){
        $request->validate([
            'NIM' => 'required',
            'no_hp' => 'required',
            'semester' => 'required',
            'prodi' => 'required',
        ]);
    
        // Dapatkan user yang sedang login
        $user = auth()->user();
        session([
            'level' => $user->level,
            'NIM' => $user->NIM,
            'semester' => $user->semester,
            'no_hp' => $user->no_hp
        ]);
        // Update data user berdasarkan inputan
        $user->NIM = $request->NIM;
        $user->no_hp = $request->no_hp;
        $user->semester = $request->semester;
        $user->prodi = $request->prodi;
        $user->save();
    
        // Redirect kembali ke halaman profile dengan pesan sukses
        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }
    
   public function ustatus(Request $request)
{
    $id = $request->input('id');
    $mdlakun = mdlakun::find($id);
    
    $valdat = $request->validate([
        'level' => 'required',
        'email' => 'required'
    ]);

    $mdlakun->update($valdat);

    return redirect()->route('daftarakun')->with('success', 'Data Berhasil Diperbarui');

}

}
