<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    authctrl, akunctrl, ruangctrl, ruangpjmctrl, alatctrl, alatrskctrl, alatpjmctrl,
    bahanctrl, bahanusectrl, belictrl, heafoctrl, brgctrl
};
use App\Http\Middleware\CekLogin;
use App\Http\Middleware\CheckUserRole;

// Routes for authentication
Route::get('/', [authctrl::class, 'index'])->name('home');
Route::get('/auth', [authctrl::class, 'index']);
Route::get('/auth/redirect', [authctrl::class, 'redirect'])->name('auth/redirect');
Route::get('/auth/callback', [authctrl::class, 'callback']);
Route::get('/auth/logout', [authctrl::class, 'logout'])->name('logout');

// Routes for profile
//LOGIN
Route::get('/myprofile', [akunctrl::class, 'profile'])->middleware(CheckUserRole::class)->name('profile');

// Routes for Dashboard
Route::get('/Laboran', [authctrl::class, 'dlaboran'])->middleware(CheckUserRole::class)->name('dlaboran');

// Grouped routes for Akun
Route::prefix('akun')->middleware(CheckUserRole::class)->group(function () {
    Route::get('/', [akunctrl::class, 'index'])->name('akun')->middleware(CekLogin::class);
    Route::post('/upakun', [akunctrl::class, 'update'])->name('upakun');
    Route::get('/takun', fn() => view('Laboran/Daftar.tambahakun'))->name('takun')->middleware(CekLogin::class);
    Route::post('/ustatus', [akunctrl::class, 'ustatus'])->name('ustatus')->middleware(CekLogin::class);
    Route::get('/daftar', [akunctrl::class, 'daftarakun'])->name('daftarakun');
});

// Grouped routes for Ruang
Route::prefix('ruang')->middleware(CheckUserRole::class)->group(function () {
    Route::get('/', [ruangctrl::class, 'index'])->name('ruang');

    Route::middleware(CekLogin::class)->group(function () {
    Route::get('/truang', fn() => view('Laboran/ruangan.tambahruang'))->name('truang');
    Route::post('/insert', [ruangctrl::class, 'insert']);
    Route::delete('/hapus', [ruangctrl::class, 'delete']);
    Route::put('/update/{id}', [ruangctrl::class, 'update'])->name('ruang.update');
    });
});

// Grouped routes for Ruang Pinjam
//LOGIN
Route::prefix('ruangpjm')->middleware(CheckUserRole::class)->group(function () {
    Route::get('/', [ruangpjmctrl::class, 'index'])->name('ruangpjm');
    Route::get('/truangpjm', [ruangpjmctrl::class, 'truangpjm'])->name('truangpjm');
    Route::post('/insert', [ruangpjmctrl::class, 'insert']);
    Route::delete('/hapus', [ruangpjmctrl::class, 'delete']);
    Route::put('/update', [ruangpjmctrl::class, 'update'])->name('ubah');
    Route::get('/print/{id}', [ruangpjmctrl::class, 'print'])->name('printruangpjm');
    Route::post('/filter', [ruangpjmctrl::class, 'filter'])->name('ruangpjm.filter');
});

// Grouped routes for Alat
Route::prefix('alat')->middleware(CheckUserRole::class)->group(function () {
    Route::get('/', [alatctrl::class, 'index'])->name('alat');

    Route::middleware(CekLogin::class)->group(function () {
    Route::get('/talat', fn() => view('Laboran/alat.tambahalat'))->name('talat');
    Route::post('/insert', [alatctrl::class, 'insert']);
    Route::delete('/hapus', [alatctrl::class, 'delete']);
    Route::put('/update', [alatctrl::class, 'update'])->name('alat.update');
    Route::get('/get-alat-satuan/{nama_alat}', [alatctrl::class, 'getSatuan']);
    Route::post('/rusak', [alatrskctrl::class, 'insert'])->name('alat/rusak');
    Route::post('/bmn/rusak', [alatrskctrl::class, 'insertbmn'])->name('bmn.ucak');
    Route::post('/baik', [alatrskctrl::class, 'upbaik'])->name('alat/baik');
    Route::get('/ucak', [alatrskctrl::class, 'index'])->name('alat.ucak');
    Route::get('/rusak/riwayat', [alatrskctrl::class, 'riwayat'])->name('riwayatucak');
});});

// Grouped routes for Alat Pinjam
//LOGIN
Route::prefix('alatpjm')->middleware(CheckUserRole::class)->group(function () {
    Route::get('/', [alatpjmctrl::class, 'index'])->name('alatpjm');
    Route::get('/talatpjm', [alatpjmctrl::class, 'tindex'])->name('talatpjm');
    Route::post('/insert', [alatpjmctrl::class, 'insert']);
    Route::delete('/hapus', [alatpjmctrl::class, 'delete']);
    Route::put('/update', [alatpjmctrl::class, 'update'])->name('alatpjm.update');
    Route::get('/print', [alatpjmctrl::class, 'print'])->name('printalatpjm');
    Route::get('/search', [alatpjmctrl::class, 'search'])->name('searchalat');
    Route::post('/updateMultiple', [alatpjmctrl::class, 'updateMultiple'])->name('updateMultiple');
    Route::post('/updateMultipleStatus', [alatpjmctrl::class, 'updateMultipleStatus'])->name('updateMultipleStatus');
    Route::post('/alatkembali', [alatpjmctrl::class, 'alatkembali'])->name('alatkembali');
});

// Grouped routes for Bahan
Route::prefix('bahan')->middleware(CheckUserRole::class)->group(function () {
    Route::get('/', [bahanctrl::class, 'index'])->name('bahan');

    Route::middleware(CekLogin::class)->group(function () {
    Route::get('/tbahan', fn() => view('Laboran/Bahan.tambahbahan'))->name('tbahan');
    Route::post('/insert', [bahanctrl::class, 'insert']);
    Route::delete('/hapus', [bahanctrl::class, 'delete']);
    Route::put('/update', [bahanctrl::class, 'update'])->name('bahan.update');
    Route::get('/get-bahan-satuan/{nama_bahan}', [bahanctrl::class, 'getBahanSatuan']);
});});

// Grouped routes for Bahan Pakai
//LOGIN
Route::prefix('bahanpakai')->middleware(CheckUserRole::class)->group(function () {
    Route::get('/', [bahanusectrl::class, 'index'])->name('bahan_pakai');
    Route::get('/tbahan', [bahanusectrl::class, 'viewtbahan'])->name('tambah_pemakaian');
    Route::post('/insert', [bahanusectrl::class, 'insert']);
    Route::delete('/hapus', [bahanusectrl::class, 'delete']);
    Route::put('/update/{id}', [bahanusectrl::class, 'update'])->name('bahan_pakai.update');
    Route::get('/print', [bahanusectrl::class, 'print'])->name('printbah');
    Route::get('/search', [bahanusectrl::class, 'search'])->name('searchbahan');
});

// Grouped routes for Pembelian
Route::prefix('beli')->middleware(CekLogin::class)->group(function () {
    Route::get('/', [belictrl::class, 'index'])->name('beli');
    Route::get('/print', [belictrl::class, 'print'])->name('beliprint');
    Route::get('/tbeli', [belictrl::class, 'tbeli'])->name('tbeli');
    Route::post('/insert', [belictrl::class, 'insert']);
    Route::delete('/hapus', [belictrl::class, 'delete']);
    Route::post('/update', [belictrl::class, 'update'])->name('pembelian.update');
    Route::get('/search', [belictrl::class, 'search'])->name('search');
});

// Grouped routes for Draft Peminjaman
Route::prefix('draft')->middleware(CekLogin::class)->group(function () {
    Route::get('/', [heafoctrl::class, 'indjam'])->name('draftpinjam');
    Route::get('/mhs', [heafoctrl::class, 'indjammhs'])->name('draftpinjammhs');
    Route::post('/bahanpakai', [heafoctrl::class, 'statbahmhs'])->name('stabahmhs');
    Route::post('/pinjamalat', [heafoctrl::class, 'mhsstat'])->name('mhsstat');
});

// Route for Peminjaman
Route::get('/peminjaman', [heafoctrl::class, 'indexDraft'])->name('alat-pjm.index-draft');
Route::get('/peminjaman/riwayat', [heafoctrl::class, 'riwayat'])->name('Riwayat');
Route::post('/pinjamalat', [ruangpjmctrl::class, 'statusruang'])->name('izinruangan');
