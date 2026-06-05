<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;

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

    // ✅ DARI DENIS — wajib ada untuk MitraApprovalController::index()
    // yang pakai Mitra::with('user'), tanpa ini akan error
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Ada di kedua versi — aman
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Ada di kedua versi — aman
    public function facilities()
    {
        return $this->hasMany(Facility::class, 'mitra_id');
    }
}