<?php

namespace App\Http\Controllers;

use App\Models\AbsensiSiswa;
use App\Models\Berita;
use App\Models\Siswa;
use App\Models\Izin;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    // Menampilkan halaman absensi
    public function index()
    {
        // Mendapatkan id_siswa dari session
        $id_siswa = session('id_siswa');
        
        // Jika id_siswa tidak ada di session, redirect ke halaman login
        if (!$id_siswa) {
            return redirect()->route('login');
        }

        // Ambil data siswa berdasarkan id_siswa dari session
        $siswa = Siswa::find($id_siswa);
        
        // Tentukan nilai default untuk foto profil, nama, dan kelas jika data tidak ditemukan
        $foto_profil = $siswa->foto_profil ?? 'uploads/default_profile.png';
        $name = $siswa->name ?? 'Nama Tidak Ditemukan';
        $kelas_siswa = $siswa->kelas ?? 'Kelas Tidak Ditemukan';

        // Ambil berita terbaru
        $berita_terbaru = Berita::latest()->first();

        // Kembalikan view absensi.index dengan data yang diperlukan
        return view('absensi.index', compact('foto_profil', 'name', 'kelas_siswa', 'berita_terbaru'));
    }

    // Menangani permintaan absen
    public function absen(Request $request)
    {
        // Mendapatkan id_siswa dari session
        $id_siswa = session('id_siswa');
        
        // Jika id_siswa tidak ada di session, redirect ke halaman login
        if (!$id_siswa) {
            return redirect()->route('login');
        }

        // Jika absen berhasil, redirect kembali ke halaman absensi dengan pesan sukses
        return redirect()->route('absensi.index')->with('message', 'Absen berhasil dilakukan.');
    }

    // Menangani permintaan izin
    public function izin(Request $request)
    {
        // Mendapatkan id_siswa dari session
        $id_siswa = session('id_siswa');
        
        // Validasi alasan izin
        $alasan = trim($request->alasan);
        
        // Menyimpan tanggal izin
        $tanggal_izin = now();

        // Ambil data siswa berdasarkan session id
        $siswa = Siswa::find($id_siswa);

        // Buat data izin baru
        $izin = new Izin([
            'id_siswa' => $id_siswa,
            'tanggal' => $tanggal_izin,
            'alasan' => $alasan,
            'name' => $siswa->name,
            'kelas' => $siswa->kelas
        ]);
        
        // Simpan data izin
        $izin->save();

        // Redirect ke halaman absensi dengan pesan sukses
        return redirect()->route('absensi.index')->with('message', 'Izin berhasil diajukan.');
    }

    // Mendapatkan data absensi berdasarkan kelas dan jurusan
    public function getAbsensi(Request $request)
    {
        // Ambil kelas dan jurusan dari request
        $kelas = $request->input('kelas');
        $jurusan = $request->input('jurusan');
        
        // Query untuk mengambil data absensi siswa
        $absensi = AbsensiSiswa::query();
        
        // Jika kelas ada, filter berdasarkan kelas
        if ($kelas) {
            $absensi->where('kelas', $kelas);
        }
        
        // Jika jurusan ada, filter berdasarkan jurusan
        if ($jurusan) {
            $absensi->where('jurusan', $jurusan);
        }
        
        // Kembalikan hasil query dalam format JSON
        return response()->json($absensi->get());
    }

    // Mendapatkan data izin berdasarkan kelas
    public function getIzin(Request $request)
    {
        // Ambil kelas dari request
        $kelas = $request->input('kelas');
        
        // Query untuk mengambil data izin siswa
        $izin = Izin::query();
        
        // Jika kelas ada, filter berdasarkan kelas
        if ($kelas) {
            $izin->where('kelas', $kelas);
        }
        
        // Kembalikan hasil query dalam format JSON
        return response()->json($izin->get());
    }
}
