<?php

namespace App\Policies;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DriverPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Driver $driver)
    {
        return $user->id === $driver->rental_id;
    }

    public function update(User $user, Driver $driver)
    {
        return $user->id === $driver->rental_id;
    }

    public function delete(User $user, Driver $driver)
    {
        return $user->id === $driver->rental_id;
    }
}
