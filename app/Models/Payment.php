<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function booking() {
    return $this->belongsTo(Booking::class);
}

    // Relasi ke Refund (Satu payment bisa mengajukan satu refund)
public function refund()
{
    return $this->hasOne(Refund::class, 'payment_id');
}

}