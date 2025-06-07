<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ViewDetailTest extends DuskTestCase
{
    /**
     * TC.ViewDetail.001
     * Test menampilkan detail kendaraan.
     * @group view-detail
     */
    public function test_view_vehicle_detail()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('username', 'pelanggandusk') // atau 'email', sesuaikan dengan form login Anda
                ->type('password', 'password')
                ->press('@submit-login')
                ->assertPathIs('/user/dashboard')

                // ke halaman daftar mobil
                ->visit('/vehicles')
                // klik link detail mobil pertama (pastikan ada data dummy)
                ->clickLink('Detail') // atau ->click('@detail-link') jika pakai dusk selector
                ->pause(1000)
                // cek spesifikasi, harga sewa, dan status ketersediaan tampil
                ->assertSee('Deskripsi')
                ->assertSee('/hari');
        });
    }
    /**
 * TC.ViewDetail.002
 * Test cek spesifikasi kendaraan pada halaman detail.
 * @group view-detail
 */
public function test_view_vehicle_specification()
{
    $this->browse(function (Browser $browser) {
        $browser->visit('/login')
            ->type('username', 'pelanggandusk') // atau 'email', sesuaikan dengan form login Anda
            ->type('password', 'password')
            ->press('@submit-login')
            ->assertPathIs('/user/dashboard')

            // ke halaman daftar mobil
            ->visit('/vehicles')
            // klik link detail mobil pertama
            ->clickLink('Detail') // atau ->click('@detail-link') jika pakai dusk selector
            ->pause(1000)
            // cek tab/bagian spesifikasi tampil
            ->assertSee('Deskripsi')
            // cek beberapa detail spesifikasi (ganti sesuai data dummy Anda)
            ->assertSee('Lokasi')
            ->assertSee('Plat Nomor')
            ->assertSee('Tahun');
    });
}
/**
 * TC.ViewDetail.003
 * Test gagal membuka detail kendaraan karena data rusak/tidak lengkap.
 * @group view-detail
 */
public function test_view_vehicle_detail_with_broken_data()
{
    $this->browse(function (Browser $browser) {
        $browser->visit('/login')
            ->type('username', 'pelanggandusk')
            ->type('password', 'password')
            ->press('@submit-login')
            ->assertPathIs('/user/dashboard')

            // ke halaman daftar mobil
            ->visit('/vehicles')
            // klik link detail mobil rusak (ganti 'Detail Rusak' sesuai label/link mobil rusak)
            ->clickLink('Detail') // pastikan mobil rusak ada di urutan pertama/tertentu
            ->pause(1000)
            // cek pesan error tampil
            ->assertSee('N/A')
            // atau jika redirect ke halaman error:
            // ->assertPathIs('/error')
            ;
    });
}
/**
 * TC.ViewReview.001
 * Test menampilkan ulasan pengguna lain di halaman detail kendaraan.
 * @group view-review
 */
public function test_view_vehicle_review()
{
    $this->browse(function (Browser $browser) {
        $browser->visit('/login')
            ->type('username', 'pelanggandusk')
            ->type('password', 'password')
            ->press('@submit-login')
            ->assertPathIs('/user/dashboard')

            // ke halaman daftar mobil
            ->visit('/vehicles')
            // klik link detail mobil pertama
            ->clickLink('Detail')
            ->pause(1000)
            // cek review pengguna tampil
            ->assertSee('Ulasan Pengguna') // atau label lain yang menandakan review tampil
            ->assertSee('Mobil sangat nyaman dan bersih!'); // atau isi review dummy Anda
    });
}
}