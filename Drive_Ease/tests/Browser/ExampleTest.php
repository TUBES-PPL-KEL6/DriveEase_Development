<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
<<<<<<< Updated upstream
=======
    /**
     * A basic browser test example.
     */
>>>>>>> Stashed changes
    public function testBasicExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
<<<<<<< Updated upstream
                    ->assertSee('DriveEase'); // ganti dengan teks nyata di halaman landing kamu
=======
                    ->assertSee('Laravel');
>>>>>>> Stashed changes
        });
    }
}
