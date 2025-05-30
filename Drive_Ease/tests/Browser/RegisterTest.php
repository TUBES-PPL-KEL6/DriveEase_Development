<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    // use DatabaseMigrations;

    /**
     * Test registrasi berhasil.
     * @group register
     */
    public function test_register_success()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->select('role', 'pelanggan') // Sesuaikan dengan <select name="role">
                    ->type('name', 'Test User')
                    ->type('email', 'user@example.com')
                    ->type('username', 'testuser123') // Ini tambahan dari blade Tuan
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->press('@submit-register');// pastikan tombol benar pakai label ini
                
        });
    }
}
