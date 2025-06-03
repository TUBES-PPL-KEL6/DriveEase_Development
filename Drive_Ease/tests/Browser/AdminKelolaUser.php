<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class AdminKelolaUser extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testKelolaUser(): void
    {
       $this->browse(function (Browser $browser) {
            // Ambil user admin dari tabel users (kolom "username" = "admin").
            $admin = User::where('username', 'admin')->first();

            $browser->loginAs($admin)
                    ->visit('/admin/users')
                    ->assertSee('Kelola User')
                    ->assertSee('Username')
                    ->assertSee('Email')
                    ->assertSeeIn('table thead tr th:first-child', 'Username')
                    ->screenshot('AdminKelolaUser');
        });
    }
}
