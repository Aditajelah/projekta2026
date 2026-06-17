<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Culinary extends Model
{
    protected $table = 'culinaries';
    protected $primaryKey = 'id_culinaries';

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
        'operational_schedule',
        'transport_modes',
        'price',
        'rating',
        'cuisine_type',
        'amenities',
        'description',
        'image_url',
        'status_lokasi',
    ];

    protected $casts = [
        'operational_schedule' => 'array',
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
