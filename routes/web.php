<?php
use App\Http\Controllers\bmnctrl;
use App\Http\Controllers\brgctrl;
use App\Http\Controllers\akunctrl;
use App\Http\Controllers\alatctrl;
use App\Http\Controllers\authctrl;
use App\Http\Controllers\belictrl;
use App\Http\Controllers\bahanctrl;
use App\Http\Controllers\heafoctrl;
use App\Http\Controllers\ruangctrl;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\alatpjmctrl;
use App\Http\Controllers\alatrskctrl;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\bahanusectrl;
use App\Http\Controllers\ruangpjmctrl;
use Laravel\Socialite\Facades\Socialite;



// Routes for authentication
Route::get('/', [authctrl::class, "index"]);
Route::get('/auth', [authctrl::class, "index"]);
Route::get('/auth/redirect', [authctrl::class,"redirect"])->name('auth/redirect');
Route::get('/auth/callback', [authctrl::class,"callback"]);
Route::get('/auth/logout', [authctrl::class, "logout"])->name('logout')->middleware('auth');

// Routes for profile
Route::get('/myprofile', [akunctrl::class, "profile"])->name('profile');

// Routes for Laboran
Route::get('/Laboran', [authctrl::class,"dlaboran"])->name('dlaboran');

// Grouped routes for Akun
Route::prefix('akun')->group(function () {
    Route::get('/', [akunctrl::class,"index"])->name('akun');
    Route::post('/upakun', [akunctrl::class,"update"])->name('upakun');
    Route::get('/takun', function () {
        return view('Laboran/Daftar.tambahakun');
    })->name('takun');
    Route::post('/ustatus', [akunctrl::class,"ustatus"])->name('ustatus');
});

// Grouped routes for Ruang
Route::prefix('ruang')->group(function () {
    Route::get('/', [ruangctrl::class,"index"])->name('ruang');
    Route::get('/truang', function () {
        return view('Laboran/ruangan.tambahruang');
    })->name('truang');
    Route::post('/insert', [ruangctrl::class, "insert"]);
    Route::delete('/hapus', [ruangctrl::class, "delete"]);
    Route::put('/update/{id}', [ruangctrl::class, "update"])->name('ruang.update');
});

// Grouped routes for Ruang Pinjam
Route::prefix('ruangpjm')->group(function () {
    Route::get('/', [ruangpjmctrl::class,"index"])->name('ruangpjm');
    Route::get('/truangpjm',[ruangpjmctrl::class,"truangpjm"])->name('truangpjm');
    Route::post('/insert', [ruangpjmctrl::class, "insert"]);
    Route::delete('/hapus', [ruangpjmctrl::class, "delete"]);
    Route::put('/update', [ruangpjmctrl::class, "update"])->name ('ubah');
    Route::get('/print/{id}', [ruangpjmctrl::class, "print"])->name('printruangpjm');

});

// Grouped routes for Alat
Route::prefix('alat')->group(function () {
    Route::get('/', [alatctrl::class,"index"])->name('alat');
    Route::get('/talat', function() {
        return view('Laboran/alat.tambahalat');
    })->name('talat');
    Route::post('/insert', [alatctrl::class, "insert"]);
    Route::delete('/hapus', [alatctrl::class, "delete"]);
    Route::put('/update', [alatctrl::class, "update"])->name('alat.update');
    Route::get('/get-alat-satuan/{nama_alat}', [alatctrl::class, 'getSatuan']);
});

// Grouped routes for Alat Rusak
Route::prefix('alat')->group(function () {
    Route::post('/rusak', [alatrskctrl::class, 'insert'])->name('alat/rusak');
    Route::post('/bmn/rusak', [alatrskctrl::class, 'insertbmn'])->name('bmn.ucak');
    Route::post('/baik', [alatrskctrl::class, 'upbaik'])->name('alat/baik');
    Route::get('/ucak', [alatrskctrl::class, 'index'])->name('alat.ucak');
    Route::get('/bmn', [bmnctrl::class, 'index'])->name('alat.bmn');
    Route::post('/bmn/tambah', [bmnctrl::class, 'insert'])->name('bmn.tambah');
    Route::get('/rusak/riwayat', [alatrskctrl::class, 'riwayat'])->name('riwayatucak');

});

// Grouped routes for Alat Pinjam
Route::prefix('alatpjm')->group(function () {
    Route::get('/', [alatpjmctrl::class,"index"])->name('alatpjm');
    Route::get('/talatpjm', [alatpjmctrl::class, "tindex"])->name('talatpjm');
    Route::post('/insert', [alatpjmctrl::class, "insert"]);
    Route::delete('/hapus', [alatpjmctrl::class, "delete"]);
    Route::put('/update', [alatpjmctrl::class, "update"])->name('alatpjm.update');
    Route::get('/print', [alatpjmctrl::class,"print"])->name('printalatpjm');
    Route::get('/search', [alatpjmctrl::class, "search"])->name('searchalat');
    Route::post('/updateMultiple', [alatpjmctrl::class, 'updateMultiple'])->name('updateMultiple');
    Route::post('/updateMultipleStatus', [alatpjmctrl::class, 'updateMultipleStatus'])->name('updateMultipleStatus');
});

// Grouped routes for Bahan
Route::prefix('bahan')->group(function () {
    Route::get('/', [bahanctrl::class,"index"])->name('bahan');
    Route::get('/tbahan', function() {
        return view('Laboran/Bahan.tambahbahan');
    })->name('tbahan');
    Route::post('/insert', [bahanctrl::class, "insert"]);
    Route::delete('/hapus', [bahanctrl::class, "delete"]);
    Route::put('/update', [bahanctrl::class, "update"])->name('bahan.update');
    Route::get('/get-bahan-satuan/{nama_bahan}', [bahanctrl::class, 'getBahanSatuan']);
});

// Grouped routes for Bahan Pakai
Route::prefix('bahanpakai')->group(function () {
    Route::get('/', [bahanusectrl::class,"index"])->name('bahan_pakai');
    Route::get('/tbahan',[bahanusectrl::class, "viewtbahan"])->name('tambah_pemakaian');
    Route::post('/insert', [bahanusectrl::class, "insert"]);
    Route::delete('/hapus', [bahanusectrl::class, "delete"]);
    Route::put('/update/{id}', [bahanusectrl::class, "update"])->name('bahan_pakai.update');
    Route::get('/print', [bahanusectrl::class,"print"])->name('printbah');
    Route::get('/search', [bahanusectrl::class, "search"])->name('searchbahan');
});

// Grouped routes for Pembelian
Route::prefix('beli')->group(function () {
    Route::get('/', [belictrl::class,"index"])->name('beli');
    Route::get('/print', [belictrl::class,"print"])->name('beliprint');
    Route::get('/tbeli', [belictrl::class,"tbeli"])->name('tbeli');
    Route::post('/insert', [belictrl::class, "insert"]);
    Route::delete('/hapus', [belictrl::class, "delete"]);
    Route::post('/update', [belictrl::class, "update"])->name("pembelian.update");
    Route::get('/search', [belictrl::class, "search"])->name('search');
});

// Grouped routes for Peminjaman (Draft)
Route::prefix('draft')->group(function () {
    Route::get('/', [heafoctrl::class, 'indjam'])->name('draftpinjam');
    Route::get('/mhs', [heafoctrl::class, 'indjammhs'])->name('draftpinjammhs');
    Route::post('/bahanpakai', [heafoctrl::class, 'statbahmhs'])->name('stabahmhs');
    Route::post('/pinjamalat', [heafoctrl::class, 'mhsstat'])->name('mhsstat');
    Route::post('/alatkembali', [alatpjmctrl::class, 'alatkembali'])->name('alatkembali');

});

// Grouped routes for Barang
Route::prefix('barang')->group(function () {
    Route::get('/', [brgctrl::class, 'index'])->name('barang.index');
});

// Route for peminjaman
Route::get('/peminjaman', [heafoctrl::class, 'indexDraft'])->name('alat-pjm.index-draft');
Route::delete('/alat-bmn-hapus', [bmnctrl::class, 'delete'])->name('bmn-hapus');

// Route untuk mengupdate data BMN
Route::put('/alat-bmn-update/{id_bmn}', [bmnctrl::class, 'update'])->name('bmn-update');

Route::get('/peminjaman/riwayat', [heafoctrl::class, 'riwayat'])->name('Riwayat');
Route::post('/pinjamalat', [ruangpjmctrl::class, 'statusruang'])->name('izinruangan');
Route::get('/akun/daftar', [akunctrl::class, 'daftarakun'])->name('daftarakun');
Route::post('/ruangpjm/filter', [ruangpjmctrl::class, 'filter'])->name('ruangpjm.filter');



