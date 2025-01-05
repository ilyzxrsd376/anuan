<?php
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DaftarController;



Route::get('/daftar', [DaftarController::class, 'showForm'])->name('daftar.form');
Route::post('/daftar', [DaftarController::class, 'store'])->name('daftar.store');

Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman setelah login
Route::get('/dashboard', function () {
    return view('admin.dashboard'); // Halaman dashboard admin
})->name('dashboard')->middleware('auth');

Route::get('/absensi', function () {
    return view('siswa.absensi'); // Halaman absensi siswa
})->name('absensi')->middleware('auth');
