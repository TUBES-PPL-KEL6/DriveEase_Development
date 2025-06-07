<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminLoginTest extends DuskTestCase
{
    /**
     * TC.LoginAdmin.001
     * Test login admin sukses.
     * @group admin-login
     */
    public function test_admin_login_success()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('username', 'adminlogin') // atau 'email', jika form login pakai email
                ->type('password', 'password')
                ->press('@submit-login') // pastikan tombol login punya dusk="submit-login"
                ->assertPathIs('/admin/dashboard'); // sesuaikan jika dashboard admin beda url
        });
    }
    public function test_admin_login_invalid_credentials()
{
    $this->browse(function (Browser $browser) {
        $browser->visit('/login')
            ->type('username', 'adminlogin') // atau 'email', jika form login pakai email
            ->type('password', 'password_salah') // password salah
            ->press('@submit-login')
            ->pause(1000)
            // Ganti string di bawah sesuai pesan error login di aplikasi Anda:
            ->assertSee('These credentials do not match our records');
            // atau jika pakai bahasa Indonesia:
            // ->assertSee('Email atau password salah');
    });
}
}