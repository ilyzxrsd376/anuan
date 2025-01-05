<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function send(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'user' => 'required|string',
            'message' => 'required|string',
        ]);

        // Simpan pesan ke database atau buat dummy response untuk testing
        // Contoh ini hanya mengembalikan data input sebagai response JSON
        $chatMessage = [
            'user' => $validatedData['user'],
            'message' => $validatedData['message'],
            'timestamp' => now()->toDateTimeString(),
        ];

        // Kembalikan response JSON sebagai konfirmasi
        return response()->json([
            'status' => 'success',
            'data' => $chatMessage
        ]);
    }
}
