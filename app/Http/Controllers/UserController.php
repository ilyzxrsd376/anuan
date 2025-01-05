<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Guru;


class UserController extends Controller
{
    public function getSiswa(Request $request)
    {
        $username = $request->input('username');  // Ambil username dari request

        // Cari siswa berdasarkan username
        $siswa = Siswa::where('username', $username)->first();  // Menggunakan where() agar bisa mencari berdasarkan username

        if ($siswa) {
            return response()->json([
                'username' => $siswa->username ?? '',
                'name' => $siswa->name ?? '',
                'jurusan' => $siswa->jurusan,
                'foto_profil' => $siswa->foto_profil ?? 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png',
                'role' => $siswa->role ?? 'siswa',  // Default role jika tidak ada
                'is_secretary' => (bool) $siswa->is_secretary ?? false,
                'is_admin' => (bool) $siswa->is_admin ?? false,
                'is_teacher' => (bool) $siswa->is_teacher ?? false,

            ]);
        } else {
            return response()->json(['error' => 'Siswa not found'], 404);
        }
    }
    public function getGuru(Request $request)
{
    $username = $request->input('username');

    $guru = Guru::where('username', $username)->first();

    if ($guru) {
        $response = [
            'username' => $guru->username ?? 'guru',
            'name' => $guru->name ?? 'tidak ada',
            'wali_kelas' => $guru->wali_kelas ?? '',
            'foto_profil' => $guru->foto_profil ?? 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png',
            'role' => $guru->role ?? 'guru',
            'jenis_kelamin' => $guru->jenis_kelamin ?? 'Laki-laki',
            'mapel' => $guru->mapel ?? 'tidak ada mapel',
            'is_admin' => (bool) $guru->is_admin ?? false,
            'is_teacher' => (bool) $guru->is_teacher ?? false,
        ];

        // Debugging
        \Log::info('Guru Response:', $response);

        return response()->json($response);
    } else {
        return response()->json(['error' => 'Guru not found'], 404);
    }
}

}
