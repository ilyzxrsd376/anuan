<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';

    protected $fillable = [
        'username',
        'password',
        'name',
        'kelas',
        'jurusan',
        'is_admin',
        'is_secretary',
        'is_teacher',
        'points',
    ];

    protected $hidden = [
        'password', // Jangan kirim password ke client
    ];
}
