<?php

namespace App\Http\Controllers;

use App\Models\mdlakun;
use Illuminate\Http\Request;

class akunctrl extends Controller
{
    public function index(){
        $akun = mdlakun::all();
        return view('Laboran/akun.akun', ['akun'=>$akun]);
    }

    public function profile(){

        $user = auth()->user();

        return view('Laboran/akun.detailakun', ['user' => $user]);

    }
}
