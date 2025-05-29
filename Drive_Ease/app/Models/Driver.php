<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'photo',
        'rental_id',
    ];

    // Relasi dengan model DriverJob
    public function jobs()
    {
        return $this->hasMany(DriverJob::class);
    }

    public function rental()
    {
        return $this->belongsTo(User::class, 'rental_id');
    }
}
