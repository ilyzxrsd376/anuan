<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'absensi_siswa';
    protected $fillable = ['kelas', 'tanggal_absen', 'status_absen', 'name'];
}
