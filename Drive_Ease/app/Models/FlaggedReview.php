<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlaggedReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'review_id',
        'rental_id',
        'reason',
        'details',
        'status',
        'admin_notes'
    ];

    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    public function rental()
    {
        return $this->belongsTo(User::class, 'rental_id');
    }
} 