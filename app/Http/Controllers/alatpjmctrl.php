<?php

namespace App\Http\Controllers;

use App\Models\mdlalatpjm;
use Illuminate\Http\Request;

class alatpjmctrl extends Controller
{
    public function index(){
        $alat = mdlalatpjm::all();
        return view('Laboran/alat pinjam.alatpjm', ['alat'=>$alat]);
    }
}
