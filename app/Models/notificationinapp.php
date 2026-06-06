<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationInapp extends Model
{
    public $timestamps = false;
    protected $table = 'notifications_inapp';

    protected $fillable = [
        'user_id', 'title', 'message', 'type', 'is_read', 'data',
    ];

    protected $casts = [
        'data'    => 'array',
        'is_read' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper: kirim notifikasi ke satu user
    public static function send(int $userId, string $title, string $message, string $type = 'system', array $data = []): self
    {
        return self::create([
            'user_id' => $userId,
            'title'   => $title,
            'message' => $message,
            'type'    => $type,
            'data'    => $data ?: null,
        ]);
    }
}