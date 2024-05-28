<?php
use App\Http\Controllers\akunctrl;
use App\Http\Controllers\alatctrl;
use App\Http\Controllers\authctrl;
use App\Http\Controllers\belictrl;
use App\Http\Controllers\bahanctrl;
use App\Http\Controllers\ruangctrl;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\alatpjmctrl;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ruangpjmctrl;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth', [authctrl::class, "index"]);
Route::get('/auth/redirect', [authctrl::class,"redirect"]);
Route::get('/auth/callback', [authctrl::class,"callback"]);
Route::get('/myprofile', [akunctrl::class, "profile"])->name('profile');
Route::get('/auth/logout', [authctrl::class, "logout"])->name('logout')->middleware('auth');

// Rute
Route::get('/Laboran', [authctrl::class,"dlaboran"])->name('dlaboran');
Route::get('/akun', [akunctrl::class,"index"])->name('akun');
Route::get('/akun/takun', function () {return view('laboran/akun.tambahakun');})->name('takun');

Route::get('/ruang', [ruangctrl::class,"index"])->name('ruang');
Route::get('/ruang/truang', function () {return view('laboran/ruangan.tambahruang');})->name('truang');
Route::post('/ruang-insert', [ruangctrl::class, "insert"]);
Route::delete('/ruang-hapus', [ruangctrl::class, "delete"]);

Route::get('/ruangpjm', [ruangpjmctrl::class,"index"])->name('ruangpjm');
Route::get('/ruangpjm/truangpjm', function () {return view('laboran/ruang pinjam.tambahruangpjm');})->name('truangpjm');
Route::post('/ruangpjm-insert', [ruangpjmctrl::class, "insert"]);
Route::delete('/ruangpjm-hapus', [ruangpjmctrl::class, "delete"]);

Route::get('/alat', [alatctrl::class,"index"])->name('alat');
Route::get('/alat/talat', function() {return view('laboran/alat.tambahalat');})->name('talat');
Route::post('/alat-insert', [alatctrl::class, "insert"]);
Route::delete('/alat-hapus', [alatctrl::class, "delete"]);

Route::get('/alatpjm', [alatpjmctrl::class,"index"])->name('alatpjm');
Route::get('/alatpjm/talatpjm', function() {return view('laboran/Alat Pinjam.tambahalatpjm');})->name('talatpjm');
Route::post('/alatpjm-insert', [alatpjmctrl::class, "insert"]);
Route::delete('/alatpjm-hapus', [alatpjmctrl::class, "delete"]);

Route::get('/bahan', [bahanctrl::class,"index"])->name('bahan');
Route::get('/bahan/tbahan', function() {return view('laboran/bahan.tambahbahan');})->name('tbahan');
Route::post('/bahan-insert', [bahanctrl::class, "insert"]);
Route::delete('/bahan-hapus', [bahanctrl::class, "delete"]);


Route::get('/beli', [belictrl::class,"index"])->name('beli');
Route::get('/beli/tbeli', function() {return view('laboran/pembelian.tambahbeli');})->name('tbeli');
Route::post('/beli-insert', [belictrl::class, "insert"]);
Route::delete('/beli-hapus', [belictrl::class, "delete"]);







