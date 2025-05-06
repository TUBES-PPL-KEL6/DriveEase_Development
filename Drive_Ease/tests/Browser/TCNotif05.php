<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class TCNotif05 extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize()
                ->loginAs(User::where('role', 'pelanggan')->first())
                ->visit('/payment/checkout')
                ->type('@harga-input', '100000')
                ->click('@checkout-submit-button')
                ->loginAs(User::where('role', 'rental')->first())
                ->visit('/rental/dashboard')
                ->click('@notification-button')
                ->pause(3000)
                ->assertSee('Penyewaan Baru')
                ->screenshot('TCNotif05');
        });
    }
}
