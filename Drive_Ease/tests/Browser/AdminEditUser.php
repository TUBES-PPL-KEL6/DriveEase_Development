<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class AdminEditUser extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testEditUser(): void
    {
         $this->browse(function (Browser $browser) {
            $admin = User::where('username', 'admin')->first();

            $browser->loginAs($admin)
                    ->visit('/admin/users')
                    ->assertSee('Edit') // Pastikan tombol edit ada
                    ->clickLink('Edit') // Klik tombol edit pertama
                    ->assertPathBeginsWith('/admin/users/')
                    ->assertPathEndsWith('/edit')
                    ->assertSee('Edit User') // Asumsikan halaman edit punya heading ini
                    ->screenshot('AdminEditUser');
        });
    }
}
