<?php

namespace App\Http\Controllers;

use App\Models\mdlbrg;

class brgctrl extends Controller
{
    public function index()
    {
        $barangs = mdlbrg::all(); // Ambil semua data barang dari database
        return view('barang.index', compact('barangs'));
    }
}
