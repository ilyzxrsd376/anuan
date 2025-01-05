<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'guru';
    protected $primaryKey = 'id_guru';

    protected $fillable = [
        'username',
        'password',
        'name',
        'wali_kelas',
        'is_admin',
        'is_teacher',
        'foto_profil',
        'role',
        'jenis_kelamin',

    ];

    protected $hidden = [
        'password', // Jangan kirim password ke client
    ];
    protected $attributes = [
        'wali_kelas' => 'Tidak ada',
        'foto_profil' => 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png',
        'mapel' => 'tidak ada mapel',
        'role' => 'guru',
    ];
    
}
