<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Soal;
use App\Models\Siswa;
use Illuminate\Support\Facades\Session;

class QuizController extends Controller
{
    // Fungsi untuk mengambil soal berdasarkan jurusan dan level
    public function getQuizData($jurusan, $level)
    {
        // Ambil soal pertama berdasarkan jurusan dan level
        $soal = Soal::where('jurusan', $jurusan)
                    ->where('level', $level)
                    ->first();

        // Cek jika soal tidak ditemukan
        if (!$soal) {
            return response()->json([
                'message' => 'Quiz not found for jurusan: ' . $jurusan . ' and level: ' . $level
            ], 404);
        }

        // Jika soal ditemukan, kembalikan data soal dalam bentuk JSON
        return response()->json([
            'id' => $soal->id,
            'title' => $soal->pertanyaan,
            'jurusan' => $soal->jurusan,
            'jawaban_a' => $soal->jawaban_a,
            'jawaban_b' => $soal->jawaban_b,
            'jawaban_c' => $soal->jawaban_c,
            'jawaban_d' => $soal->jawaban_d,
            'jawaban_benar' => $soal->jawaban_benar,
            'level' => $soal->level,
            'sudah_dijawab' => $soal->sudah_dijawab,
        ]);
    }

    // Fungsi untuk mengirimkan jawaban dan melanjutkan ke soal berikutnya
    public function submitAnswer(Request $request, $jurusan, $level)
{
    // Ambil parameter username dari query string
    $username = $request->query('username'); // Ambil 'username' dari query string

    if (!$username) {
        return response()->json([
            'status' => 'error',
            'message' => 'Username tidak ditemukan.'
        ], 400);
    }

    // Cari siswa berdasarkan username
    $siswa = Siswa::where('username', $username)->first();

    if (!$siswa) {
        return response()->json([
            'status' => 'error',
            'message' => 'Siswa tidak ditemukan.'
        ], 404);
    }

    // Proses jawaban yang dikirimkan
    $validated = $request->validate([
        'jawaban' => 'required|string',
        'level' => 'required|integer',
    ]);

    // Ambil soal berdasarkan ID dan level
    $soal = Soal::where('jurusan', $jurusan)
                ->where('level', $level)
                ->first();

    if (!$soal) {
        return response()->json([
            'status' => 'error',
            'message' => 'Soal tidak ditemukan untuk jurusan ' . $jurusan . ' dan level ' . $level,
        ], 404);
    }

    // Periksa apakah jawaban benar
    $isCorrect = $soal->jawaban_benar === $validated['jawaban'];

    // Simpan status soal sebagai sudah dijawab
    $soal->update(['sudah_dijawab' => true]);

    // Jika jawaban benar, tambahkan poin ke siswa
    if ($isCorrect) {
        $siswa->increment('points', 10); // Tambahkan 10 poin
    }

    // Cek soal berikutnya untuk level yang lebih tinggi
    $nextLevel = $validated['level'] + 1;
    $nextSoal = Soal::where('jurusan', $siswa->jurusan)
                    ->where('level', $nextLevel)
                    ->first();

    // Kembalikan respons
    return response()->json([
        'correct' => $isCorrect,
        'message' => $isCorrect ? 'Jawaban Anda benar!' : 'Jawaban Anda salah.',
        'next_question' => $nextSoal ? true : false,
        'next_level' => $nextLevel,
        'next_question_data' => $nextSoal ? [
            'id' => $nextSoal->id,
            'title' => $nextSoal->pertanyaan,
            'jawaban_a' => $nextSoal->jawaban_a,
            'jawaban_b' => $nextSoal->jawaban_b,
            'jawaban_c' => $nextSoal->jawaban_c,
            'jawaban_d' => $nextSoal->jawaban_d,
        ] : null,
    ]);
}
}
