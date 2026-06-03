<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function payments() {
    return $this->hasMany(Payment::class);
}
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
        // Pastikan nama kolom foreign key di tabel bookings lu adalah 'user_id'
    }
}
