<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
    protected $fillable = ['name', 'position', 'number', 'team_category', 'gender', 'photo'];
}