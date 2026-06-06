<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'action', 'model', 'model_id', 'before', 'after', 'ip_address', 'description',
    ];

    protected $casts = [
        'before' => 'array',
        'after'  => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper: tulis log
    public static function record(string $action, string $model, ?int $modelId = null, ?array $before = null, ?array $after = null, ?string $description = null): self
    {
        return self::create([
            'user_id'     => Auth::id(),
            'action'      => $action,
            'model'       => $model,
            'model_id'    => $modelId,
            'before'      => $before,
            'after'       => $after,
            'ip_address'  => Request::ip(),
            'description' => $description,
        ]);
    }
}