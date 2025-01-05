<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'content']; // Sesuaikan dengan kolom di tabel

    public function user()
    {
        return $this->belongsTo(User::class); // Asumsikan ada relasi dengan model User
    }
}
