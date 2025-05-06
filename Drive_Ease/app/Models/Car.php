<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    /** @use HasFactory<\Database\Factories\CarFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function rents()
    {
        return $this->hasMany(Rent::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> a12a50e6f22bd2accec52c882319b39038630ff6

    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class);
    }

    public function getAverageRatingAttribute()
    {
        return round($this->reviews()->avg('rating'), 1); // dibulatkan 1 angka di belakang koma
    }
<<<<<<< HEAD

>>>>>>> main
=======
>>>>>>> a12a50e6f22bd2accec52c882319b39038630ff6
}
