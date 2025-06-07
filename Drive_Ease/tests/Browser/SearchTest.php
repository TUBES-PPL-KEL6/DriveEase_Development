<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SearchTest extends DuskTestCase
{
    /**
     * TC.Search.001
     * Test pencarian kendaraan dengan semua filter.
     * @group search
     */
    public function test_search_with_all_filters()
{
    $this->browse(function (Browser $browser) {
        $browser->visit('/login')
            ->type('username', 'pelanggandusk') // atau 'email', sesuaikan dengan form login Anda
            ->type('password', 'password')
            ->press('@submit-login')
            ->assertPathIs('/user/dashboard') // pastikan login berhasil

            // lanjut ke halaman vehicles dan lakukan filter
            ->visit('/vehicles')
            ->type('location', 'Jakarta')
            ->type('price_min', '100000')
            ->type('price_max', '500000')
            ->select('category', 'SUV')
            ->press('@submit-search')
            ->pause(1000)
            ->assertSee('SUV');
    });
}

public function test_search_with_no_result()
{
    $this->browse(function (Browser $browser) {
        $browser->visit('/login')
            ->type('username', 'pelanggandusk') // atau 'email', sesuaikan dengan form login Anda
            ->type('password', 'password')
            ->press('@submit-login')
            ->assertPathIs('/user/dashboard')

            // lanjut ke halaman vehicles dan lakukan filter yang tidak mungkin ada
            ->visit('/vehicles')
            ->type('location', 'LokasiTidakAda')
            ->type('price_min', '99999999')
            ->type('price_max', '99999999')
            ->select('category', 'SUV')
            ->press('@submit-search')
            ->pause(1000)
            ->assertSee('Tidak Ada Kendaraan Ditemukan'); // pastikan pesan tidak ada hasil sesuai dengan yang ada di aplikasi Anda
    });
}
}