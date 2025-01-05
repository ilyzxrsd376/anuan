<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Guru;

class GuruController extends Controller
{
    public function getGuruProfile(Request $request)
    {
        $username = $request->input('username');
        $guru = Guru::where('username', $username)->first();

        if ($guru) {
            $profileImageUrl = asset('storage/' . $guru->foto_profil);

            return response()->json([
                'name' => $guru->name,
                'username' => $guru->username,
                'wali_kelas' => $guru->wali_kelas,
                'foto_profil' => $profileImageUrl, 
                'role' => $guru->role,
                'is_admin' => $guru->is_admin,
                'is_teacher' => $guru->is_teacher,
                'jenis_kelamin' => $guru->jenis_kelamin,

            ]);
        }

        return response()->json(['message' => 'User not found'], 404);
    }
    public function getUserData($username)
    {
        // Cari data guru berdasarkan username
        $guru = Guru::where('username', $username)->first();

        // Jika data ditemukan, kembalikan respons dengan data guru
        if ($guru) {
            return response()->json([
                'status' => 'success',
                'data' => $guru,
            ]);
        }

        // Jika data tidak ditemukan, kembalikan respons error
        return response()->json([
            'status' => 'error',
            'message' => 'User not found',
        ], 404);
    }
}
