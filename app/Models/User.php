<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'prodi',
        'phone',
        'role', // ✅ DARI DENIS — WAJIB ADA
                // Tanpa 'role' di fillable, saat register mitra role tidak tersimpan
                // dan middleware role:admin / role:mitra tidak akan berfungsi
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }
    public function schedules()
{
    return $this->belongsToMany(\App\Models\Schedule::class, 'schedule_user')->withTimestamps();
}
}