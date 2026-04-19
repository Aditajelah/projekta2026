<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $table = 'destinations';
    protected $primaryKey = 'id_destinations';

    protected $fillable = [
        'name',
        'location',
        'place_address',
        'city',
        'province',
        'latitude',
        'longitude',
        'operational_days',
        'operational_hours',
        'transport_modes',
        'price',
        'rating',
        'description',
        'category',
        'image_url',
        'status_lokasi',
    ];

    protected $casts = [
        'transport_modes' => 'array',
    ];

    public function ratings()
    {
        return $this->morphMany(Rating::class, 'rateable');
    }

    public function comments()
    {
        return $this->morphMany(Rating::class, 'rateable')->whereNotNull('review');
    }

    public function bookmarks()
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }
}
