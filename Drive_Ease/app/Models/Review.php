<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'rental_id',
        'rating',
        'comment',
        'is_approved',
        'reported_at',
        'report_reason',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'reported_at' => 'datetime',
        'rating' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function car() {
        return $this->belongsTo(Car::class);
    }

    public function rental()
    {
        return $this->belongsTo(User::class, 'rental_id');
    }

    /**
     * Scope a query to only include approved reviews.
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope a query to only include reported reviews.
     */
    public function scopeReported($query)
    {
        return $query->whereNotNull('reported_at');
    }

    /**
     * Get the average rating for a vehicle.
     */
    public static function getAverageRating($vehicleId)
    {
        return static::where('vehicle_id', $vehicleId)
            ->where('is_approved', true)
            ->avg('rating');
    }

    /**
     * Check if the review is reported.
     */
    public function isReported(): bool
    {
        return !is_null($this->reported_at);
    }
}
