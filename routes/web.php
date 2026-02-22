<?php

use App\Models\Requirement;
use App\Models\Assignment;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

// 1. HALAMAN DEPAN
Route::get('/', function () {
    // Menghapus .with('school') karena sekarang kita pakai school_name (string)
    // Bukan lagi relasi ke tabel User
    $lowongans = Requirement::latest()->take(6)->get();
    return view('welcome', compact('lowongans'));
});

// 2. PROSES REGISTER RELAWAN (Tetap Sama)
Route::post('/register-volunteer', function (Request $request) {
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|string',
        'password' => 'required|min:8|confirmed',
    ]);

    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'phone' => $data['phone'],
        'password' => Hash::make($data['password']),
        'role' => 'volunteer',
    ]);

    Auth::login($user);
    return redirect('/')->with('success', 'Akun berhasil dibuat! Silakan pilih lowongan.');
})->name('register.custom');

// 3. PROSES LAMAR LANGSUNG
Route::post('/apply-lowongan/{id}', function (Request $request, $id) {
    if (!auth()->check()) {
        return back()->with('error', 'Silakan login terlebih dahulu.');
    }

    // CEK APAKAH SUDAH PERNAH MELAMAR
    $exists = Assignment::where('volunteer_id', auth()->id())
                        ->where('requirement_id', $id)
                        ->exists();

    if ($exists) {
        return back()->with('error', 'Anda sudah melamar di lowongan ini sebelumnya.');
    }

    $request->validate([
        'file_cv' => 'required|mimes:pdf|max:2048',
    ]);

    $path = $request->file('file_cv')->store('cv-pelamar', 'public');

    Assignment::create([
        'volunteer_id' => auth()->id(),
        'requirement_id' => $id,
        'file_cv' => $path,
        'status' => 'pending',
    ]);

    return back()->with('success', 'Lamaran Anda berhasil dikirim!');
})->name('lowongan.apply');

// PROSES LOGIN RELAWAN
Route::post('/login-volunteer', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        
        // Cek jika user adalah volunteer, arahkan ke dashboard relawan
        if (auth()->user()->role === 'volunteer') {
            return redirect('/relawan')->with('success', 'Selamat datang kembali!');
        }
        
        return redirect('/')->with('success', 'Login Berhasil!');
    }

    return back()->with('error', 'Email atau password salah.');
})->name('login.custom');