<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $fillable = ['payment_id', 'reason', 'amount', 'status', 'admin_note'];

    // Relasi balik ke Payment
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
}