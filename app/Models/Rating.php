<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'user_id',
        'rateable_type',
        'rateable_id',
        'parent_id',
        'rating',
        'review',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rateable()
    {
        return $this->morphTo();
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function scopeComments($query)
    {
        return $query->whereNotNull('review');
    }

    public function scopeWithRating($query)
    {
        return $query->whereNotNull('rating');
    }
}
