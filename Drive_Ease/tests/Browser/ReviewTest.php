<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Models\Vehicle;

class ReviewTest extends DuskTestCase
{
    /**
     * A Dusk test example,
     * @group review
    */
    public function test_view_reviews_on_detail_page()
    {
        $vehicle = Vehicle::factory()->create();

        $this->browse(function (Browser $browser) use ($vehicle) {
            $browser->visit('/vehicles/' . $vehicle->id)
                    ->assertSee('Ulasan');
        });
    }
}
