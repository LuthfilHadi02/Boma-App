<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    // ✅ PAKAI VERSI DENIS — Akmal tidak punya 'amenities' dan 'gmaps_link'
    // Tanpa ini, field baru dari migration Denis tidak bisa disimpan
    protected $fillable = [
        'mitra_id',
        'name',
        'type',
        'floor_type',
        'price_per_hour',
        'image',
        'description',
        'amenities',
        'gmaps_link',
        'opening_time',
        'closing_time',
        'is_active',
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }
}