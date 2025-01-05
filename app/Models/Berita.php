<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'judul', 'isi', 'lokasi', 'status_event', 'gambar', 'tanggal', 'is_event', 'is_news'
    ];

    protected $table = 'berita';
}
