<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Vehicle;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ReviewDisplaysCorrectlyTest extends DuskTestCase
{
    public function test_review_displays_rating_and_comment()
    {
        $this->browse(function (Browser $browser) {
            $user = User::where('username', 'testuser123')->first();
            $vehicle = Vehicle::has('reviews')->first(); // ambil kendaraan yang ada review-nya
            $review = $vehicle->reviews->first(); // ambil salah satu review

            $browser->maximize()
                    ->loginAs($user)
                    ->visit('/vehicles/' . $vehicle->id)
                    ->assertSee($review->comment)
                    ->assertSee((string) $review->rating . ' ⭐') // pastikan bentuk rating sesuai di blade
                    ->screenshot('ReviewDisplaysCorrectlyTest');
        });
    }
}
