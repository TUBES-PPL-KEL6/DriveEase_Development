<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Vehicle;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserCanDeleteReviewTest extends DuskTestCase
{
    public function test_user_can_delete_review()
    {
        $this->browse(function (Browser $browser) {
            // Ambil user dan kendaraan (pastikan data ada di database)
            $user = User::where('username', 'testuser123')->first();
            $vehicle = Vehicle::first();

            $browser->maximize()
                ->loginAs($user)
                ->visit('/vehicles/' . $vehicle->id)
                ->pause(1000)
                ->assertSee('Hapus') // pastikan tombol hapus muncul
                ->click('@btn-hapus-review') // gunakan selector manual atau find by text jika tak pakai dusk selector
                ->whenAvailable('.swal2-popup', function ($modal) {
                    $modal->assertSee('Yakin hapus ulasan?')
                          ->click('.swal2-confirm');
                })
                ->pause(2000) // tunggu submit selesai
                ->assertSee('Kirim Ulasan') // form muncul kembali setelah ulasan dihapus
                ->screenshot('UserCanDeleteReviewTest');
        });
    }
}
