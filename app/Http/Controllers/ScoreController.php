<?php  

// app/Http/Controllers/ScoreController.php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|exists:siswa,username',
            'poin' => 'required|integer',
        ]);

        // Temukan siswa berdasarkan username
        $siswa = Siswa::where('username', $request->username)->first();

        if ($siswa) {
            // Update kolom poin di tabel siswa
            $siswa->poin = $request->poin;
            $siswa->save();

            return response()->json(['status' => 'success']);
        }

        return response()->json(['error' => 'Siswa tidak ditemukan'], 404);
    }
}
