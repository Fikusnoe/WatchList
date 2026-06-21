<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function watchlistUsers()
    {
        return $this->belongsToMany(User::class, 'watchlists', 'work_id', 'user_id')
            ->withPivot('status')
            ->withTimestamps();
    }
}

