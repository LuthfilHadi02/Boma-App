<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    // Daftarkan semua kolom yang boleh diisi secara massal (mass assignment)
    protected $fillable = [
        'user_id',
        'facility_id',
        'booking_date',
        'start_time',
        'jumlah_sesi',
        'total_price',
        'status',
    ];

    // =========================================================================
    // RELASI
    // =========================================================================

    // Booking ini milik user siapa
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Booking ini untuk lapangan mana
    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }

    // Satu booking bisa punya banyak payment (history retry bayar)
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Ambil payment terbaru / aktif (yang paling relevan ditampilkan)
    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }
}