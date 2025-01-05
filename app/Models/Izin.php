<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;
    
    protected $table = 'izin';
    protected $fillable = [
        'id', 'id_siswa', 'tanggal', 'alasan', 'name', 'kelas',
    ];
}
