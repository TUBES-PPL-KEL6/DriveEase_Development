<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class LoginTest extends DuskTestCase
{
    /**
     * @group login
     */
    public function test_login_success()
    {
        $this->browse(function (Browser $browser) {
            $user = User::where('username', 'testuser123')->first();

            $browser->loginAs($user)
                    ->visit('/user/dashboard')
                    ->assertPathIs('/user/dashboard');
        });
    }
}
