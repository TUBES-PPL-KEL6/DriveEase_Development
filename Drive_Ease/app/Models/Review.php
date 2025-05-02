<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

//     public function reviews()
// {
//     return $this->hasMany(Review::class);
// }

public function user()
{
    return $this->belongsTo(User::class);
}

public function vehicle()
{
    return $this->belongsTo(Vehicle::class);
}
    use HasFactory;

    protected $fillable = ['user_id', 'car_id', 'rating', 'comment'];


    public function car() {
        return $this->belongsTo(Car::class);
    }


}
