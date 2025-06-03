<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class AdminTransaksi extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $admin = User::where('username', 'admin')->first(); // Sesuaikan dengan role admin kamu

            $browser->loginAs($admin)
                    ->visit('/admin/transactions')
                    ->assertSee('Daftar Profit Rental')
                    ->assertSee('NAMA RENTAL')
                    ->assertSee('TOTAL PROFIT')
                    ->assertSeeIn('table thead tr th:nth-child(4)', 'TOTAL PROFIT')
                    ->screenshot('AdminTransaksi');
        });
    }
}
