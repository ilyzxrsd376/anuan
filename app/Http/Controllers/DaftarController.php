<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DaftarController extends Controller
{
    public function showForm()
    {
        return view('daftar');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|unique:siswa,username',  // Sesuaikan dengan nama tabel 'siswa'
            'password' => 'required|min:6',
            'name' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
        ]);

        // Simpan data siswa tanpa foto profil
        $siswa = new Siswa();
        $siswa->username = $request->username;
        $siswa->password = Hash::make($request->password);
        $siswa->name = $request->name;
        $siswa->kelas = $request->kelas;
        $siswa->jurusan = $request->jurusan;
        $siswa->is_admin = $request->is_admin;
        $siswa->is_teacher = $request->is_teacher;
        $siswa->is_secretary = $request->is_secretary;
        $siswa->role = $request->role;
        $siswa->save();

        return redirect()->route('home')->with('success', 'Pendaftaran berhasil!');
    }
}
