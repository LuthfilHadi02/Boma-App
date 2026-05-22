<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'mitra_id', 'name', 'type', 'floor_type', 'price_per_hour', 'image', 'description', 'is_active'
    ];

    // Hubungan data: Lapangan ini milik siapa
    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }
}