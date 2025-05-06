<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Models\Vehicle;

class VehicleDetailTest extends DuskTestCase
{
    /**
     * A Dusk test example,
     * @group vehicle
    */
    public function test_view_vehicle_detail()
    {
        $vehicle = Vehicle::factory()->create();

        $this->browse(function (Browser $browser) use ($vehicle) {
            $browser->visit('/vehicles/' . $vehicle->id)
                    ->assertSee($vehicle->name)
                    ->assertSee((string)$vehicle->price_per_day);
        });
    }

    public function test_view_detail_invalid_vehicle()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/vehicles/999999')
                    ->assertSee('404') // atau sesuaikan dengan pesan error-nya
                    ->assertDontSee('Spesifikasi');
        });
    }
}
