<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class TCNotif01 extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize()
                ->loginAs(User::where('role', 'rental')->first())
                ->visit('/rental/rents')
                ->press('@lihat-detail-button')
                ->click('@konfirmasi-sewa-button')
                ->pause(2000)
                ->click('@konfirmasi-sewa-confirm-button')
                ->loginAs(User::where('role', 'pelanggan')->first())
                ->visit('/user/dashboard')
                ->click('@notification-button')
                ->pause(3000)
                ->assertSee('Penyewaan Dikonfirmasi')
                ->screenshot('TCNotif01');
        });
    }
}