<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function resetPassword(Request $request)
{
    // Validasi input
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'new_password' => 'required|string|min:6|confirmed',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Cari siswa berdasarkan email
    $siswa = Siswa::where('email', $request->email)->first();

    if (!$siswa) {
        return redirect()->back()->with('error', 'Email tidak ditemukan!');
    }

    // Update password baru
    $siswa->password = Hash::make($request->new_password);
    $siswa->save();

    return redirect()->route('login')->with('success', 'Password berhasil diubah!');
}

    public function showResetPasswordForm()
{
    return view('auth.reset_password'); // Menampilkan form reset password
}

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard'); // Ganti dengan route dashboard kamu
        }

        return redirect()->route('login')->withErrors('Email atau password salah.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
