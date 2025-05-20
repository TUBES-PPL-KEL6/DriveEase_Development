<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'id_card',
        'driver_license',
        'company_name',
        'company_address',
        'business_license',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'rental_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a rental
     */
    public function isRental(): bool
    {
        return $this->role === 'rental';
    }

    /**
     * Check if user is a customer
     */
    public function isPelanggan(): bool
    {
        return $this->role === 'pelanggan';
    }

    // public function reviews()
    // {
    //     return $this->hasMany(Review::class);
    // }
}
