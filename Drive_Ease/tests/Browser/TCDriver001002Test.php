<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class TCDriver001002Test extends DuskTestCase
{
    /**
     * A Dusk test example,
     * @group review
     */
    public function testTCDriver001002()
    {

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::where('email', 'pelanggan@gmail.com')->first())
                ->visit('/dashboard')
                ->pause(1000)
                ->click('#btn-cari-kendaraan')
                ->click('.btn-lihat-detail-kendaraan')
                ->click('#btn-pesan-sekarang')
                ->type('start_date', '11082025')
                ->type('end_date', '13082025')
                ->pause(1000)
                ->click('#use-driver-button')
                ->pause(2000)
                ->screenshot('TCDriver002')
                ->pause(1000)
                ->click('.driver-profile-item')
                ->pause(1000)
                ->click('#btn-pesan-sekarang')
                ->screenshot('TCDriver001');
        });
    }
}
