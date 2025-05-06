<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminLoginRegisterTest extends DuskTestCase
{
    /**
     * A Dusk test example,
     * @group admin
    */
    public function test_admin_register_valid()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', 'Admin User')
                    ->type('email', 'admin@example.com')
                    ->select('role', 'admin')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->press('Register')
                    ->assertPathIs('/dashboard');
        });
    }

    
    public function test_admin_register_invalid_email()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', 'Admin User')
                    ->type('email', 'invalid')
                    ->select('role', 'admin')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->press('Register')
                    ->assertSee('The email must be a valid email address');
        });
    }

    /** @test @group=admin-auth */
    public function test_admin_login_invalid()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'wrongadmin@example.com')
                    ->type('password', 'wrongpassword')
                    ->press('Login')
                    ->assertSee('These credentials do not match our records');
        });
    }
}
