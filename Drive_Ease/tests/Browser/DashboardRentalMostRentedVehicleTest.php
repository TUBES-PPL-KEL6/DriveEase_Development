<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DashboardRentalMostRentedVehicleTest extends DuskTestCase
{
    /**
     * TC.DashboardRental.005
     * Test pemilik rental dapat melihat kendaraan paling banyak disewa di dashboard.
     * @group rental-dashboard
     */
    public function test_rental_owner_can_see_most_rented_vehicle_on_dashboard()
    {
        // Ambil user rental yang punya kendaraan dengan booking terbanyak
        $user = User::where('role', 'rental')
            ->whereHas('vehicles.bookings')
            ->first();

        $this->assertNotNull($user, 'Tidak ada user rental dengan kendaraan yang pernah disewa di database!');

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/rental/dashboard')
                ->assertSee('Top 5 Kendaraan Paling Banyak Disewa') // Judul section statistik kendaraan
                ->assertSee('NAMA KENDARAAN') // Judul kolom tabel
                ->assertSee('JUMLAH DISEWA') // Judul kolom tabel
                // Cek minimal satu kendaraan tampil (nama kendaraan dan jumlah sewa)
                ->assertVisible('table') // Pastikan tabel tampil
                ->screenshot('DashboardRentalMostRentedVehicleTest');
        });
    }
}