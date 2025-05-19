<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $guarded = ['id'];

    public function jobs()
    {
        return $this->hasMany(DriverJob::class);
    }
}
