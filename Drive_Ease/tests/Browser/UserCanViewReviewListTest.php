<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Vehicle;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserCanViewReviewListTest extends DuskTestCase
{
    public function test_user_can_see_review_list()
    {
        $this->browse(function (Browser $browser) {
            $user = User::where('username', 'testuser123')->first();
            $vehicle = Vehicle::has('reviews')->first(); // pastikan ada review

            $browser->maximize()
                ->loginAs($user)
                ->visit('/vehicles/' . $vehicle->id)
                ->assertSee('Ulasan Pengguna')
                ->assertSee($vehicle->reviews->first()->comment)
                ->screenshot('UserCanViewReviewListTest');
        });
    }
}
