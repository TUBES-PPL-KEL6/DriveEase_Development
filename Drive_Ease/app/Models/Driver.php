<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = ['rental_id', 'name', 'phone', 'is_active', 'schedule'];

    protected $casts = [
        'schedule' => 'array',
        'is_active' => 'boolean',
    ];

    public function rental()
    {
        return $this->belongsTo(User::class, 'rental_id');
    }
}