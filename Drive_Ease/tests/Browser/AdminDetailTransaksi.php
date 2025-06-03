<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
class AdminDetailTransaksi extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $admin = User::where('username', 'admin')->first();

            $browser->loginAs($admin)
                    ->visit('/admin/transactions')
                    ->assertSee('Daftar Profit Rental')
                    ->with('table tbody tr:nth-child(1)', function ($row) {
                        $row->assertSee('Detail')
                            ->clickLink('Detail');
                    })
                    ->pause(1000)
                    ->assertPathBeginsWith('/admin/transactions') // validasi halaman detail rental
                    ->screenshot('AdminDetailTransaksi');
        });
    }
}
