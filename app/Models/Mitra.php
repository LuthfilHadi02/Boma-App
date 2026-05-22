<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Tambahkan ini untuk seeder/factory
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory; // Tambahkan ini agar model bisa pakai Mitra::factory()

    // Daftarkan semua field yang boleh diisi secara massal
    protected $fillable = [
        'user_id',
        'brand_name',
        'address',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
        'identity_document',
        'status',
    ];

    public function bookings() {
        return $this->hasMany(Booking::class);
    }

    public function facilities()
    {
        return $this->hasMany(Facility::class, 'mitra_id');
    }
}