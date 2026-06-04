<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    // Daftarin kolom database yang boleh diisi secara massal
    protected $fillable = [
        'judul',
        'slug',
        'deskripsi_singkat',
        'konten_lengkap',
        'foto',
        'tanggal_kegiatan',
        'link'
    ];
}