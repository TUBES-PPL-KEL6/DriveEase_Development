<?php

// app/Policies/DriverPolicy.php
namespace App\Policies;

use App\Models\User;
use App\Models\Driver;

class DriverPolicy
{
    public function view(User $user, Driver $driver)
    {
        return $user->id === $driver->rental_owner_id || $user->isAdmin();
    }

    public function create(User $user)
    {
        return $user->isRentalOwner();
    }

    public function update(User $user, Driver $driver)
    {
        return $user->id === $driver->rental_owner_id;
    }

    public function delete(User $user, Driver $driver)
    {
        return $user->id === $driver->rental_owner_id || $user->isAdmin();
    }
}
