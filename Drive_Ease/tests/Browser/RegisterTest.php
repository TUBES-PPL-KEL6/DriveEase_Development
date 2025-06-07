<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    /**
     * TC.Register.001
     * Test user berhasil register dari halaman register.
     * @group register
     */
    public function test_register_success()
    {
        $unique = rand(1000, 9999);

        $this->browse(function (Browser $browser) use ($unique) {
            $browser->visit('/register')
                ->select('role', 'pelanggan')
                ->type('name', 'Test User')
                ->type('email', 'user' . $unique . '@example.com')
                ->type('username', 'testuser' . $unique)
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->press('@submit-register')
                ->visit('/dashboard');
        });
    }
    public function test_register_invalid_email()
{
    $unique = rand(1000, 9999);

    $this->browse(function (Browser $browser) use ($unique) {
        $browser->visit('/register')
            ->select('role', 'pelanggan')
            ->type('name', 'Test User')
            ->type('email', 'user' . $unique . 'example.com') // tanpa '@'
            ->type('username', 'testuser' . $unique)
            ->type('password', 'password')
            ->type('password_confirmation', 'password')
            ->press('@submit-register')
            ->pause(1000)
            // ->assertSee('Please include an') // contoh: 'email', 'valid', atau pesan error lain yang pasti muncul
            ->assertPathIs('/register');
            ;
    });
}
public function test_admin_register_success()
{
    $unique = rand(1000, 9999);

    $this->browse(function (Browser $browser) use ($unique) {
        $browser->visit('/register')
            ->select('role', 'admin')
            ->type('name', 'Admin Test')
            ->type('email', 'admin' . $unique . '@example.com')
            ->type('username', 'admintest' . $unique)
            ->type('password', 'password')
            ->type('password_confirmation', 'password')
            ->press('@submit-register')
            ->assertPathIs('/admin/dashboard'); // 
    });
}
public function test_admin_register_invalid_email()
{
    $unique = rand(1000, 9999);

    $this->browse(function (Browser $browser) use ($unique) {
        $browser->visit('/register')
            ->select('role', 'admin')
            ->type('name', 'Admin Test')
            ->type('email', 'admin' . $unique . 'example.com') // tanpa '@'
            ->type('username', 'admintest' . $unique)
            ->type('password', 'password')
            ->type('password_confirmation', 'password')
            ->press('@submit-register')
            ->pause(1000)
            // Ganti string di bawah sesuai pesan error validasi email di aplikasi Anda:
            ->assertPathIs('/register');
            // Jika backend menampilkan pesan error di halaman, bisa juga:
            // ->assertSee('The email must be a valid email address');
            // atau
            // ->assertSee('Email harus berupa alamat email yang valid');
    });
}
}