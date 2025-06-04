<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Booking;
use App\Models\Review;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Throwable;

class CustomerReviewTest extends DuskTestCase
{
    public function test_customer_can_submit_review()
    {
        \App\Models\User::updateOrCreate(
            ['username' => 'cust'],
            [
                'password' => bcrypt('12345678'),
                'role' => 'customer',
                'telepon' => '081234567890',
                'alamat' => 'Jl. Dusk Test',
            ]
        );

        $this->browse(function (Browser $browser) {
            // 1. Login as customer
            $browser->visit('/login')
                ->type('username', 'cust') 
                ->type('password', '12345678')
                ->press('Login')
                ->pause(1000) // Wait for redirect
                ->assertPathIs('/home')
                ->assertSee('Pesanan Saya');
    