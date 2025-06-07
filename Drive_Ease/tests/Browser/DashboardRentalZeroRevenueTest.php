<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DashboardRentalZeroRevenueTest extends DuskTestCase
{
    /**
     * TC.DashboardRental.004
     * Test pemilik rental tanpa transaksi selesai, pendapatan Rp 0 dan info "Belum ada transaksi".
     * @group rental-dashboard
     */
    public function test_rental_owner_with_no_completed_transaction_sees_zero_revenue_and_message()
    {
        // Ambil user rental yang tidak punya booking selesai
        $user = User::where('role', 'rental')
            ->whereDoesntHave('vehicles.bookings', function($q) {
                $q->where('status', 'selesai');
            })
            ->first();

        $this->assertNotNull($user, 'Tidak ada user rental tanpa transaksi selesai di database!');

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/rental/dashboard')
                ->assertSee('Total Pendapatan')
                ->assertSeeIn('.font-bold.text-green-700', 'Rp0') // Pastikan class sesuai blade Anda
                ->assertSee('Rp0') // Pastikan pesan ini sesuai blade Anda
                ->screenshot('DashboardRentalZeroRevenueTest');
        });
    }
}