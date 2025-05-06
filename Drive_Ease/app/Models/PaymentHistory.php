<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $table = 'bookings'; // Your table name
    protected $fillable = ['id', 'user_id', 'vehicle_id', 'start_date', 'end_date', 'status'];
}
