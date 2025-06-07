<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DashboardRentalRevenueTest extends DuskTestCase
{
    /**
     * TC.DashboardRental.003
     * Test pemilik rental dapat melihat total pendapatan di dashboard.
     * @group rental-dashboard
     */
    public function test_rental_owner_can_see_total_revenue_on_dashboard()
    {
        // Ambil user rental yang sudah punya kendaraan dan booking selesai
        $user = User::where('role', 'rental')
            ->whereHas('vehicles.bookings', function($q) {
                $q->where('status', 'selesai');
            })
            ->first();

        // Pastikan user ditemukan, jika tidak test gagal dengan pesan jelas
        $this->assertNotNull($user, 'Tidak ada user rental dengan kendaraan dan booking selesai di database!');

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/rental/dashboard')
                ->assertSee('Total Pendapatan') // Judul card
                ->assertVisible('.font-bold.text-green-700') // Nilai total pendapatan (pastikan class sesuai blade Anda)
                ->screenshot('DashboardRentalRevenueTest_TotalRevenue');
        });
    }
}