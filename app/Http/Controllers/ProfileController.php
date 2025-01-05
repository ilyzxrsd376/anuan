<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File; // Import untuk menghapus file

class ProfileController extends Controller
{
    public function upload(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'foto_profil' => 'required|image|mimes:jpeg,png,jpg',
            'username' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            // Mendapatkan username dari request
            $username = $request->input('username');

            // Mencari user di tabel siswa berdasarkan username
            $user = DB::table('siswa')->where('username', $username)->first();

            // Jika tidak ditemukan di tabel siswa, cari di tabel guru
            if (!$user) {
                $user = DB::table('guru')->where('username', $username)->first();
            }

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            // Jika user sudah memiliki foto profil lama, hapus foto yang lama
            if ($user->foto_profil) {
                $oldImagePath = public_path(str_replace(url('public/'), '', $user->foto_profil));

                // Debug: Cek path yang akan dihapus
                \Log::info('Menghapus foto lama di path: ' . $oldImagePath);

                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                    \Log::info('Foto lama berhasil dihapus');
                } else {
                    \Log::warning('Foto lama tidak ditemukan di path: ' . $oldImagePath);
                }
            }

            // Menangani file gambar
            $file = $request->file('foto_profil');
            $filename = 'profile_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);

            // Mendapatkan URL gambar yang baru
            $fileUrl = url('public/uploads/' . $filename);

            // Update foto profil di tabel yang sesuai (siswa atau guru)
            if (isset($user->foto_profil)) {
                DB::table('siswa')
                    ->where('username', $username)
                    ->update(['foto_profil' => $fileUrl]);
            } else {
                DB::table('guru')
                    ->where('username', $username)
                    ->update(['foto_profil' => $fileUrl]);
            }

            return response()->json([
                'message' => 'Foto profil berhasil diunggah',
                'foto_profil' => $fileUrl,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal mengunggah foto profil',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
