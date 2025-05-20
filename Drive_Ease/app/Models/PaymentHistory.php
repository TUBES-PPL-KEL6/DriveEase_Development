<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $table = 'payment_history'; // Your table name
    protected $fillable = ['username', 'car', 'price'];
}
