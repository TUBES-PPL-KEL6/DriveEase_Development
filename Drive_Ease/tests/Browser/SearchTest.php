<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SearchTest extends DuskTestCase
{
    /**
     * A Dusk test example,
     * @group search
    */
    public function test_search_with_all_filters()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/vehicles')
                    ->type('location', 'Jakarta')
                    ->select('category', 'SUV')
                    ->type('min_price', 100000)
                    ->type('max_price', 500000)
                    ->press('Search')
                    ->assertSee('Hasil Pencarian');
        });
    }

    public function test_search_no_result()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/vehicles')
                    ->type('location', 'Unknown')
                    ->press('Search')
                    ->assertSee('Mobil tidak ditemukan sesuai filter yang dipilih');
        });
    }
}
