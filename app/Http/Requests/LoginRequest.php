<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna dapat mengakses permintaan ini.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;  // Ganti dengan logika otorisasi jika perlu
    }

    /**
     * Dapatkan aturan validasi yang berlaku untuk permintaan ini.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string',
            'password' => 'required|string',
        ];
    }

    /**
     * Menambahkan pesan validasi kustom jika diperlukan.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => 'Username is required',
            'password.required' => 'Password is required',
        ];
    }
}
