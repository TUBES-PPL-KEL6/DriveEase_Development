<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RentalReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_id',
        'customer_id',
        'booking_id',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => 'integer'
    ];

    public function rental()
    {
        return $this->belongsTo(User::class, 'rental_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
} 