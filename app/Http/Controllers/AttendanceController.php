<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function getAttendance(Request $request)
    {
        // Mendapatkan kelas dari request
        $kelas = $request->input('kelas');
        
        // Jika kelas tidak ada, kembalikan error
        if (!$kelas) {
            return response()->json(['error' => 'Kelas is required'], 400);
        }

        // Query data absensi berdasarkan kelas yang ada di tabel siswa
        $attendanceData = Attendance::select('absensi_siswa.tanggal_absen', 'absensi_siswa.status_absen', 'siswa.name', 'siswa.kelas')
            ->join('siswa', 'absensi_siswa.id_siswa', '=', 'siswa.id_siswa')  // Melakukan join dengan tabel siswa
            ->where('siswa.kelas', $kelas)  // Filter berdasarkan kelas yang ada di tabel siswa
            ->get();

        // Mengembalikan data dalam format JSON
        return response()->json($attendanceData, 200);
    }
}