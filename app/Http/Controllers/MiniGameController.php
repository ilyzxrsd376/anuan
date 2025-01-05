<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\Siswa;
use Illuminate\Http\Request;

class MiniGameController extends Controller
{
    // Mengambil semua soal
    public function getQuestions()
    {
        $questions = Soal::all();

        return response()->json($questions, 200);
    }

    // Mengambil soal berdasarkan mapel secara random
    public function getQuestionsByMapel($mapel)
    {
        $questions = Soal::where('mapel', $mapel)->inRandomOrder()->get();

        if ($questions->isEmpty()) {
            return response()->json(['message' => 'No questions found for this mapel'], 404);
        }

        return response()->json($questions, 200);
    }

    // Admin: Tambah soal baru
    public function addQuestion(Request $request)
    {
        $request->validate([
            'mapel' => 'required|string',
            'pertanyaan' => 'required|string',
            'jawaban_a' => 'required|string',
            'jawaban_b' => 'required|string',
            'jawaban_c' => 'required|string',
            'jawaban_d' => 'required|string',
            'jawaban_benar' => 'required|string|in:jawaban_a,jawaban_b,jawaban_c,jawaban_d',
        ]);

        $question = Soal::create([
            'mapel' => $request->mapel,
            'pertanyaan' => $request->pertanyaan,
            'jawaban_a' => $request->jawaban_a,
            'jawaban_b' => $request->jawaban_b,
            'jawaban_c' => $request->jawaban_c,
            'jawaban_d' => $request->jawaban_d,
            'jawaban_benar' => $request->jawaban_benar,
        ]);

        return response()->json(['message' => 'Question added successfully', 'data' => $question], 201);
    }

    // Admin: Edit soal
    public function updateQuestion(Request $request, $id)
    {
        $question = Soal::find($id);

        if (!$question) {
            return response()->json(['message' => 'Question not found'], 404);
        }

        $request->validate([
            'mapel' => 'string',
            'pertanyaan' => 'string',
            'jawaban_a' => 'string',
            'jawaban_b' => 'string',
            'jawaban_c' => 'string',
            'jawaban_d' => 'string',
            'jawaban_benar' => 'string|in:jawaban_a,jawaban_b,jawaban_c,jawaban_d',
        ]);

        $question->update($request->all());

        return response()->json(['message' => 'Question updated successfully', 'data' => $question], 200);
    }

    // Admin: Hapus soal
    public function deleteQuestion($id)
    {
        $question = Soal::find($id);

        if (!$question) {
            return response()->json(['message' => 'Question not found'], 404);
        }

        $question->delete();

        return response()->json(['message' => 'Question deleted successfully'], 200);
    }

    // Memeriksa jawaban siswa dan memperbarui poin
    public function checkAnswer(Request $request)
    {
        $request->validate([
            'username' => 'required|string', // Username siswa
            'jawaban' => 'required|string',  // Jawaban siswa
            'question_id' => 'required|integer', // ID soal
        ]);

        $question = Soal::find($request->question_id);

        if (!$question) {
            return response()->json(['message' => 'Question not found'], 404);
        }

        $isCorrect = $request->jawaban === $question->jawaban_benar;

        if ($isCorrect) {
            $siswa = Siswa::where('username', $request->username)->first();

            if ($siswa) {
                $siswa->points += 10; // Tambah 10 poin jika jawaban benar
                $siswa->save();

                return response()->json(['message' => 'Correct answer!', 'points' => $siswa->points], 200);
            } else {
                return response()->json(['message' => 'User not found'], 404);
            }
        } else {
            return response()->json(['message' => 'Incorrect answer.'], 200);
        }
    }
}
