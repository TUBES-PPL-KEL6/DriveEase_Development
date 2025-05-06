<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Vehicle;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserCanSubmitReviewTest extends DuskTestCase
{
    /**
     * Test pengguna bisa mengirim ulasan.
     * @group review
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            // Ambil user dan kendaraan yang sudah ada
            $user = User::where('username', 'testuser123')->first();
            $vehicle = Vehicle::first(); // pastikan data ada
            
            $browser->maximize()
                ->loginAs($user)
                ->visit('/vehicles/' . $vehicle->id)
                ->assertSee('Kirim Ulasan') // pastikan form muncul
                ->select('rating', '4')
                ->type('comment', 'Ini ulasan dari Dusk test terbaru')
                ->press('Kirim Ulasan')
                ->pause(1000)
                ->assertDontSee('Kirim Ulasan') // form hilang setelah submit
                ->assertSee('Ini ulasan dari Dusk test terbaru') // komentar muncul
                ->screenshot('UserCanSubmitReviewTest');
        });
    }
}
