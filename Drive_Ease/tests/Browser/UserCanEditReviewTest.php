<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Vehicle;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserCanEditReviewTest extends DuskTestCase
{
    public function test_user_can_edit_review()
    {
        $this->browse(function (Browser $browser) {
            $user = User::where('username', 'testuser123')->first();
            $vehicle = Vehicle::whereHas('reviews', fn ($q) => $q->where('user_id', $user->id))->first();

            $browser->maximize()
                ->loginAs($user)
                ->visit('/vehicles/' . $vehicle->id)
                ->clickLink('Edit') // pastikan link Edit ada dan bisa diklik
                ->pause(500) // beri waktu form tampil
                ->select('rating', '5')
                ->type('comment', 'Ulasan telah diedit')
                ->press('Update')
                ->pause(1000)
                ->assertSee('5 ⭐')
                ->assertSee('Ulasan telah diedit')
                ->screenshot('UserCanEditReviewTest');
        });
    }
}
