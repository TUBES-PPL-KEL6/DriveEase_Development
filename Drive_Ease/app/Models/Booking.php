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
}