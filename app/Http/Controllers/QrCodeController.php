<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function scan(Request $request)
    {
        $qrData = $request->input('qr_data');
        // Lakukan validasi atau proses QR code di sini
        
        return response()->json(['message' => 'QR code processed', 'data' => $qrData]);
    }
}
