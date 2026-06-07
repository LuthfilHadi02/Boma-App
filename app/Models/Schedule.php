<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    
    // Buka gerbang biar semua kolom bisa diisi
    protected $guarded = ['id']; 
    public function users()
{
    return $this->belongsToMany(\App\Models\User::class, 'schedule_user')->withTimestamps();
}
}