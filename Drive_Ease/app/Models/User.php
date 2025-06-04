<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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
        'telepon',
        'alamat',
    ];

    /**
     * Relasi: User memiliki banyak Booking
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Relasi: User (sebagai pelanggan) memiliki banyak rents
     */
    public function rents()
    {
        return $this->hasMany(\App\Models\Booking::class, 'user_id');
    }

    /**
     * Relasi: User (sebagai rental) memiliki banyak vehicles
     */
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'rental_id');
    }

    /**
     * Relasi: User memiliki banyak drivers (jika ada fitur supir)
     */
    public function drivers()
    {
        return $this->hasMany(Driver::class);
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
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Optional: jika kamu ingin aktifkan relasi review
    // public function reviews()
    // {
    //     return $this->hasMany(Review::class);
    // }
}
