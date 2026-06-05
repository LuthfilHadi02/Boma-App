<?php
// FILE INI HANYA ADA DI AKMAL — Denis tidak punya
// Salin ke: app/Models/Berita.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $fillable = [
        'judul',
        'slug',
        'deskripsi_singkat',
        'konten_lengkap',
        'foto',
        'tanggal_kegiatan',
        'link',
    ];
}