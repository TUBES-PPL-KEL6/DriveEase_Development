<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DashboardRentalZeroBookingTest extends DuskTestCase
{
    /**
     * TC.DashboardRental.002
     * Test pemilik rental login tanpa kendaraan, jumlah pemesanan = 0 dan pesan "Belum ada pemesanan".
     * @group rental-dashboard
     */
    public function test_rental_owner_with_no_vehicle_sees_zero_booking_and_message()
    {
        // Ambil user rental yang TIDAK punya kendaraan
        $user = User::where('role', 'rental')->doesntHave('vehicles')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/rental/dashboard')
                ->assertSee('Total Pemesanan')
                ->assertSeeIn('.font-bold.text-blue-800', '0') // Pastikan class sesuai blade Anda
                ->assertSee('Belum ada pemesanan') // Pesan yang muncul jika belum ada pemesanan
                ->screenshot('DashboardRentalZeroBookingTest');
        });
    }
}