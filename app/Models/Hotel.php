<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'total_rooms',
        'address',
        'description',
        'amenities',
        'user_id',
        'rating',
        'price_per_night'
    ];

    protected $casts = [
        'amenities' => 'array',
        'rating' => 'decimal:1'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(HotelImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function updateRating()
    {
        $averageRating = $this->reviews()
            ->avg('rating');
        
        // Round to 1 decimal place and ensure it's not null
        $this->rating = round($averageRating ?? 0, 1);
        $this->save();
    }

    public function roomTypes()
    {
        return $this->hasMany(RoomType::class);
    }
}