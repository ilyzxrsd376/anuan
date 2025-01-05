<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiSiswa extends Model
{
    use HasFactory;
    
    protected $table = 'absensi_siswa';
    protected $fillable = [
        'id_absensi', 'id_siswa', 'name', 'kelas', 'jurusan', 'tanggal_absen', 'status_absen', 'foto_profil',
    ];
}
