<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User; // Tambahkan ini untuk menggunakan model User
use Illuminate\Support\Facades\Route; // Tambahkan ini untuk menggunakan Route
use Illuminate\Support\Facades\File;

class authctrl extends Controller
{

    public function index(){
        return view('auth.index');
    }

    public function dlaboran(){
        return view('laboran.index');
    }

    public function redirect()
    {
        $prompt = Auth::check() ? null : 'select_account';
    return Socialite::driver('google')->with(['prompt' => $prompt])->redirect();
    }

    public function callback()
{
        $user = Socialite::driver('google')->user();
    

    $email = $user->email;

    // Memeriksa apakah alamat email memiliki domain @politala.ac.id
    if (strpos($email, 'politala.ac.id') === false) {
        // Jika bukan alamat email dari @politala.ac.id, kembalikan pesan error
        return response()->json(['error' => 'Hanya email dari @politala.ac.id yang diizinkan.'], 403);
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
    } else {
        // Jika pengguna belum ada, tetapkan level menjadi 'Mahasiswa'
        $userData['level'] = 'Mahasiswa';
    }

    // Simpan atau perbarui pengguna dalam database
    $user = User::updateOrCreate(
        ['email' => $email],
        $userData
    );

    // Otentikasi pengguna
    Auth::login($user);

    // Redirect pengguna ke halaman yang sesuai setelah login
    return redirect()->to('Laboran');
}

public function logout(){
    Auth::logout();
    return redirect('auth');
}

}
