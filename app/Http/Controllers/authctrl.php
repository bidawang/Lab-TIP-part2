<?php

namespace App\Http\Controllers;

use App\Models\mdlalat;
use App\Models\mdlbahan;
use App\Models\mdlruang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User; // Tambahkan ini untuk menggunakan model User
use Illuminate\Support\Facades\Route; // Tambahkan ini untuk menggunakan Route

class authctrl extends Controller
{
    public function index(){
        return view('auth.index');
    }

    public function dlaboran(){
        $alat = mdlalat::all();
        $bahan = mdlbahan::all();
        $ruang = mdlruang::all();
        return view('Laboran.index', compact('alat', 'bahan', 'ruang'));
    }    

    public function redirect()
    {
        $prompt = Auth::check() ? null : 'select_account';
        return Socialite::driver('google')->with(['prompt' => $prompt])->redirect();
    }

    public function callback()
{
    try {
        $user = Socialite::driver('google')->user();
    } catch (\Exception $e) {
        return redirect()->route('auth/redirect')->with('error', 'Failed to authenticate with Google.');
    }

    $email = $user->email;

    if (strpos($email, 'politala.ac.id') === false) {
        // Jika bukan alamat email dari @politala.ac.id, kembalikan pesan error
        return redirect()->to('auth')->with('error', 'Hanya email dari @politala.ac.id yang diizinkan.');
    }

    $id = $user->id;
    $name = $user->name;
    $avatar = $user->avatar;

    // Mengambil file avatar dari URL dan menyimpannya ke dalam folder "Profil"
    $avatar_file = $id . ".jpg";
    $fileContent = file_get_contents($avatar);
    File::put(public_path("Profil/$avatar_file"), $fileContent);

    // Menyimpan data pengguna ke dalam database
    $userData = [
        'name' => $name,
        'google_id' => $id,
        'avatar' => $avatar_file,
    ];

    // Periksa apakah pengguna sudah ada dalam database
    $existingUser = User::where('email', $email)->first();

    if ($existingUser) {
        // Jika pengguna sudah ada, biarkan level tetap sama tanpa melakukan perubahan
        $userData['level'] = $existingUser->level;
        $userData['semester'] = $existingUser->semester;
        $userData['no_hp'] = $existingUser->no_hp;
        $userData['prodi'] = $existingUser->prodi;
        $userData['NIM'] = $existingUser->NIM;
    } else {
        // Jika pengguna belum ada, tetapkan level menjadi 'Mahasiswa'
        $userData['level'] = 'Mahasiswa';
    }

    // Simpan atau perbarui pengguna dalam database
    $user = User::updateOrCreate(
        ['email' => $email],
        $userData
    );

    // Periksa jika ada kolom yang belum diisi
    if (empty($user->semester) || empty($user->no_hp) || empty($user->prodi) || empty($user->NIM)) {
        // Simpan data ke session jika salah satu kolom kosong
        session([
            'level' => $user->level,
            'NIM' => $user->NIM,
            'semester' => $user->semester,
            'no_hp' => $user->no_hp
        ]);

        // Otentikasi pengguna
        Auth::login($user);

        // Redirect ke halaman /myprofile jika salah satu kolom kosong
        return redirect('/myprofile')->with('warning', 'Silakan lengkapi profil Anda di bagian Edit Profile');
    }

    // Otentikasi pengguna
    Auth::login($user);

    // Simpan level pengguna dalam sesi
    session([
        'level' => $user->level,
        'NIM' => $user->NIM,
        'semester' => $user->semester,
        'no_hp' => $user->no_hp
    ]);

    return redirect()->route('dlaboran');
}


    public function logout(){
        Auth::logout();
        return redirect('auth');
    }
}
