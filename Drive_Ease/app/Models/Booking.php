<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'start_date',
        'end_date',
        'driver_id',
        'total_price',
        'side_note',
        'status',
    ];

    // (optional) jika kamu punya relasi:
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function rentalReview()
    {
        return $this->hasOne(\App\Models\RentalReview::class, 'booking_id');
    }

    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class, 'booking_id');
    }
}
