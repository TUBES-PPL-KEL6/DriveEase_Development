<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class TCNotif02 extends DuskTestCase
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
                ->loginAs(User::where('role', 'pelanggan')->first())
                ->visit('/user/dashboard')
                ->click('@notification-button')
                ->pause(3000)
                ->assertDontSee('Penyewaan Dikonfirmasi')
                ->assertDontSee('Penyewaan Dibatalkan')
                ->screenshot('TCNotif02');
        });
    }
}
