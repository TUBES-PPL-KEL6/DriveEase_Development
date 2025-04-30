<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'category',
        'description',
        'price_per_day',
        'available',
        'image_path',
    ];
    

    public function rental()
    {
        return $this->belongsTo(User::class, 'rental_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
{
    return $this->hasMany(Review::class);
}

}
