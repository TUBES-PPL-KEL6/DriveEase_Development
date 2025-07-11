<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DashboardRentalNoBookingTest extends DuskTestCase
{
    /**
     * TC.DashboardRental.006
     * Test pemilik rental login tanpa ada penyewaan sama sekali.
     * @group rental-dashboard
     */
    public function test_rental_owner_with_no_booking_sees_empty_message()
    {
        // Ambil user rental yang punya kendaraan tapi belum ada booking sama sekali
        $user = User::where('role', 'rental')
            ->whereHas('vehicles')
            ->whereDoesntHave('vehicles.bookings')
            ->first();

        $this->assertNotNull($user, 'Tidak ada user rental dengan kendaraan tanpa booking di database!');

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/rental/dashboard')
                ->assertSee('Top 5 Kendaraan Paling Banyak Disewa')
                ->assertSee('0x') // Pastikan sesuai dengan pesan di blade Anda
                ->screenshot('DashboardRentalNoBookingTest');
        });
    }
}