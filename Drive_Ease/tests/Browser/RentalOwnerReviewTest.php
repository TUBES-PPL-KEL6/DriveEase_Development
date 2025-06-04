<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Review;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RentalOwnerReviewTest extends DuskTestCase
{
    /**
     * Test that rental owner can view vehicles with average ratings
     * TC.OwnerView.001
     */
    public function test_owner_can_view_vehicles_with_ratings()
    {
        $this->browse(function (Browser $browser) {
            // Create test data
            $owner = User::factory()->create(['role' => 'owner']);
            $vehicle = Vehicle::factory()->create(['user_id' => $owner->id]);
            
            // Create some reviews for the vehicle
            Review::factory()->count(3)->create([
                'vehicle_id' => $vehicle->id,
                'rating' => 4
            ]);

            // Login as owner and check vehicle list
            $browser->loginAs($owner)
                   ->visit('/owner/vehicles')
                   ->assertSee('Kendaraan Saya')
                   ->assertSee($vehicle->name)
                   ->assertSee('4.0'); // Average rating
        });
    }

    /**
     * Test display of message for vehicles without ratings
     * TC.OwnerView.002
     */
    public function test_display_message_for_vehicles_without_ratings()
    {
        $this->browse(function (Browser $browser) {
            // Create test data
            $owner = User::factory()->create(['role' => 'owner']);
            $vehicle = Vehicle::factory()->create([
                'user_id' => $owner->id
            ]);

            // Login as owner and check vehicle details
            $browser->loginAs($owner)
                   ->visit('/owner/vehicles/' . $vehicle->id)
                   ->assertSee('Belum ada rating untuk kendaraan ini');
        });
    }
} 