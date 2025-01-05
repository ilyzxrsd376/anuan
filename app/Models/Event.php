<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'berita'; // Pastikan nama tabelnya sesuai

    protected $fillable = ['judul', 'isi', 'lokasi', 'status_event', 'gambar'];
}
