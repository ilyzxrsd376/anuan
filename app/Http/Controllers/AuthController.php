<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Guru; // Tambahkan model Guru
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        \Log::info('Request masuk:', $request->all());

        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            \Log::error('Validasi gagal:', $validator->errors()->toArray());
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 400);
        }

        \Log::info('Validasi berhasil');

        // Cek apakah siswa dengan username ada
        $siswa = Siswa::where('username', $request->username)->first();

        if ($siswa) {
            // Verifikasi password siswa
            if (!Hash::check($request->password, $siswa->password)) {
                \Log::warning('Login gagal: Password salah');
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password salah',
                ], 401);
            }

            \Log::info('Login berhasil untuk username: ' . $siswa->username);

            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil',
                'data' => [
                    'id_siswa' => $siswa->id_siswa ?? '',
                    'nama' => $siswa->name ?? '',
                    'kelas' => $siswa->kelas ?? '',
                    'jurusan' => $siswa->jurusan ?? '',
                    'is_admin' => $siswa->is_admin ?? false,
                    'is_secretary' => $siswa->is_secretary ?? false,
                    'is_teacher' => $siswa->is_teacher ?? false,
                ],
            ]);
        }

        // Jika siswa tidak ditemukan, cek di tabel guru
        $guru = Guru::where('username', $request->username)->first();

        if ($guru) {
            // Verifikasi password guru
            if (!Hash::check($request->password, $guru->password)) {
                \Log::warning('Login gagal: Password salah');
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password salah',
                ], 401);
            }

            \Log::info('Login berhasil untuk username: ' . $guru->username);

            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil',
                'data' => [
                    'nama' => $guru->name ?? '',
                    'wali_kelas' => $guru->wali_kelas ?? '',
                    'mapel' => $guru->mapel ?? '',
                    'foto_profil' => $guru->foto_profil ?? '',
                    'is_admin' => $guru->is_admin ?? false,
                    'is_teacher' => $guru->is_teacher ?? false,
                    'role' => $guru->role ?? 'guru',
                ],
            ]);
        }

        \Log::warning('Login gagal: Username tidak ditemukan di siswa atau guru');
        return response()->json([
            'status' => 'error',
            'message' => 'Username atau password salah',
        ], 401);
    }
}
