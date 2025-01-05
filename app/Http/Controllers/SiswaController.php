<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Siswa;

class SiswaController extends Controller
{
    public function getSiswaProfile(Request $request)
    {
        $username = $request->input('username');
        $siswa = Siswa::where('username', $username)->first();

        if ($siswa) {
            $profileImageUrl = asset('storage/' . $siswa->foto_profil);

            return response()->json([
                'name' => $siswa->name,
                'username' => $siswa->username,
                'jurusan' => $siswa->jurusan,
                'foto_profil' => $profileImageUrl, 
                'role' => $siswa->role,
                'is_secretary' => $siswa->is_secretary,
                'is_admin' => $siswa->is_admin,
                'is_teacher' => $siswa->is_teacher,

            ]);
        }

        return response()->json(['message' => 'User not found'], 404);
    }
    public function getUserData($username)
    {
        // Cari data siswa berdasarkan username
        $siswa = Siswa::where('username', $username)->first();

        // Jika data ditemukan, kembalikan respons dengan data siswa
        if ($siswa) {
            return response()->json([
                'status' => 'success',
                'data' => $siswa,
            ]);
        }

        // Jika data tidak ditemukan, kembalikan respons error
        return response()->json([
            'status' => 'error',
            'message' => 'User not found',
        ], 404);
    }
}
