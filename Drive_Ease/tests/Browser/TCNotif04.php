<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class TCNotif04 extends DuskTestCase
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
                ->loginAs(User::where('role', 'rental')->first())
                ->visit('/rental/rents')
                ->press('@lihat-detail-button')
                ->click('@batalkan-sewa-button')
                ->pause(2000)
                ->type('@side-note-reject', 'mobil tidak tersedia')
                ->pause(2000)
                ->click('@batalkan-sewa-confirm-button')
                ->loginAs(User::where('role', 'pelanggan')->first())
                ->visit('/user/dashboard')
                ->click('@notification-button')
                ->pause(3000)
                ->assertSee('Penyewaan Dibatalkan')
                ->screenshot('TCNotif04');
        });
    }
}
