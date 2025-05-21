<?php

// app/Policies/DriverSchedulePolicy.php
namespace App\Policies;

use App\Models\User;
use App\Models\Driver;
use App\Models\DriverSchedule;

class DriverSchedulePolicy
{
    public function view(User $user, DriverSchedule $schedule)
    {
        return $user->id === $schedule->driver->rental_owner_id || $user->isAdmin();
    }

    public function create(User $user, Driver $driver)
    {
        return $user->id === $driver->rental_owner_id;
    }

    public function update(User $user, DriverSchedule $schedule)
    {
        return $user->id === $schedule->driver->rental_owner_id;
    }

    public function delete(User $user, DriverSchedule $schedule)
    {
        return $user->id === $schedule->driver->rental_owner_id;
    }
}
