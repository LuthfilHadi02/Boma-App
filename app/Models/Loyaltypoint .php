<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyPoint extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'points', 'type', 'description', 'booking_id', 'expires_at'];

    protected $casts = ['expires_at' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Total poin aktif milik user
    public static function totalForUser(int $userId): int
    {
        $earned   = self::where('user_id', $userId)->where('type', 'earned')->sum('points');
        $redeemed = self::where('user_id', $userId)->where('type', 'redeemed')->sum('points');
        return max(0, $earned - $redeemed);
    }
}