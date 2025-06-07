<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * TC.Login.001
     * Test login sukses dengan email dan password terdaftar.
     * @group login
     */
    public function test_login_success()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('username', 'testlogin')
                ->type('password', 'password')
                ->press('@submit-login') // pastikan tombol login punya dusk="submit-login"
                ->assertPathIs('/dashboard');
        });
    }

    public function test_login_invalid_credentials()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('username', 'user_salah') // username/email yang tidak terdaftar
                ->type('password', 'password_salah') // password salah
                ->press('@submit-login')
                ->pause(1000)
                ->assertSee('These credentials do not match our records');
        });
    }
}