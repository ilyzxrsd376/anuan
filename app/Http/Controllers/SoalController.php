<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Soal;

class SoalController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'jurusan' => 'required|in:akl,pm,tjkt,dkv,titl,mplb',
                'pertanyaan' => 'required|string',
                'jawaban_a' => 'required|string',
                'jawaban_b' => 'required|string',
                'jawaban_c' => 'required|string',
                'jawaban_d' => 'required|string',
                'jawaban_benar' => 'required|in:a,b,c,d',
                'level' => 'nullable|integer',
            ]);

            Soal::create($data);
            return response()->json(['message' => 'Soal berhasil disimpan'], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
