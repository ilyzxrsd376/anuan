<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SoalController;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\MiniGameController;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\ScoreController;

Route::post('/score', [ScoreController::class, 'store']);
Route::get('/siswa/{username}', [SiswaController::class, 'getUserData']);
Route::get('/siswa/jurusan/{username}', [SiswaController::class, 'getJurusan']);
Route::get('/siswa', [SiswaController::class, 'getSiswaProfile']);
Route::get('/leaderboard', function () {
    $siswa = DB::table('siswa')
        ->select(
            'name',
            'points',
            'progress_level',
            'kelas',
            DB::raw("IFNULL(foto_profil, 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png') as foto_profil")
        )
        ->get();

    return response()->json($siswa);
});
Route::post('/absensi', function (Request $request) {
    $validatedData = $request->validate([
        'name' => 'required|string',
        'kelas' => 'required|string',
        'jurusan' => 'required|string',
        'tanggal_absen' => 'required|date',
        'status_absen' => 'required|string',
    ]);

    try {
        DB::table('absensi_siswa')->insert([
            'name' => $validatedData['name'],
            'kelas' => $validatedData['kelas'],
            'jurusan' => $validatedData['jurusan'],
            'tanggal_absen' => $validatedData['tanggal_absen'],
            'status_absen' => $validatedData['status_absen'],
        ]);

        return response()->json([
            'message' => 'Data absensi berhasil disimpan.',
            'data' => $validatedData,
        ], 201);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Gagal menyimpan data absensi.',
            'error' => $e->getMessage(),
        ], 500);
    }
});
Route::get('/events/latest', [EventController::class, 'latest']);
Route::get('/events/{id}', [EventController::class, 'show']);
Route::post('/soal', [SoalController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/scan-qr', [QrCodeController::class, 'scan']);
Route::post('/events', [EventController::class, 'store']);
Route::get('/events', [EventController::class, 'getEvents']);
Route::get('/quiz-lobby', [QuizController::class, 'lobby']);
Route::get('/profile', [ProfileController::class, 'show']);
Route::get('/siswa', [UserController::class, 'getSiswa']);
Route::get('/guru', [UserController::class, 'getGuru']);
Route::get('/absensi', [AbsensiController::class, 'getAbsensi']);
Route::get('/izin', [AbsensiController::class, 'getIzin']);
Route::get('/get-wali-kelas/{username}', function ($username) {
    // Ambil kelas berdasarkan wali kelas (username)
    $kelas = \App\Models\Kelas::where('wali_kelas', $username)->first();

    if ($kelas) {
        return response()->json([
            'wali_kelas' => $kelas->wali_kelas,
            'nama_kelas' => $kelas->nama_kelas,
        ]);
    }

    return response()->json(['message' => 'Wali kelas tidak ditemukan'], 404);
});
// routes/api.php


Route::post('/profile/upload', [ProfileController::class, 'upload']);
Route::get('/acara', function () {
    $events = Berita::where('is_news', 0)->where('is_event', 1)->get();
    return response()->json($events);
});
Route::get('/news', function () {
    $news = Berita::where('is_news', 1)->where('is_event', 0)->get();
    return response()->json($news);
});
