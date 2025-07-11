<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DashboardRentalTest extends DuskTestCase
{
    /**
     * TC.DashboardRental.001
     * Test pemilik rental dapat melihat jumlah total pemesanan kendaraan di dashboard.
     * @group rental-dashboard
     */
    public function test_rental_owner_can_see_total_booking_on_dashboard()
    {
        // Ambil user rental yang sudah punya kendaraan
        $user = User::where('role', 'rental')->has('vehicles')->first();

        // Pastikan user ditemukan, jika tidak test gagal dengan pesan jelas
        $this->assertNotNull($user, 'Tidak ada user rental yang punya kendaraan di database!');

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/rental/dashboard')
                ->assertSee('Total Pemesanan') // Judul card
                ->assertVisible('.font-bold.text-blue-800') // Nilai total booking (pastikan class sesuai blade Anda)
                ->screenshot('DashboardRentalTest_TotalBooking');
        });
    }
}