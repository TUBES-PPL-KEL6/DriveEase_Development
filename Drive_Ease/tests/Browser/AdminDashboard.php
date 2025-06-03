<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
class AdminDashboard extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $admin = User::where('username', 'admin')->first();

            $browser->loginAs($admin)
                    ->visit('/admin/dashboard')
                    ->assertSee('Dashboard Admin')
                    ->assertSee('Selamat datang')
                    ->assertSee('Total Users')
                    ->assertSee('Total Rentals')
                    ->assertSee('Total Profit')
                    ->assertVisible('#userRegistrationChart')
                    ->screenshot('AdminDashboardUtama');
        });
    }
}
