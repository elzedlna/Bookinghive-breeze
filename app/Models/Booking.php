<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'hotel_id',
        'room_type_id',
        'check_in',
        'check_out',
        'number_of_rooms',
        'price_per_night',
        'total_price',
        'status'
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

} 