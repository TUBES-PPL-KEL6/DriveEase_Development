<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Review;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\WithFaker;

class UserCanOnlySubmitOneReviewTest extends DuskTestCase
{
    use WithFaker;

    public function test_user_can_only_submit_one_review()
    {
        $this->browse(function (Browser $browser) {
            // Ambil user dan kendaraan yang sudah ada (pastikan ada di DB)
            $user = User::where('username', 'testuser123')->first();
            $vehicle = Vehicle::first(); // ambil kendaraan pertama

            $browser->loginAs($user)
                    ->visit('/vehicles/' . $vehicle->id)
                    ->assertSee('Kirim Ulasan')
                    ->select('rating', '5')
                    ->type('comment', 'Ulasan otomatis dari Dusk.')
                    ->press('Kirim Ulasan')
                    ->pause(1500)
                    ->assertDontSee('Kirim Ulasan') // form hilang
                    ->assertSee('Ulasan otomatis dari Dusk.')
                    ->screenshot('after_review_submitted');
        });
    }
}
