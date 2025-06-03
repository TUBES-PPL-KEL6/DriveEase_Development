<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class TCDriver003004Test extends DuskTestCase
{
    /**
     * A Dusk test example,
     * @group review
     */
    public function testTCDriver003004()
    {

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::where('email', 'rental@gmail.com')->first())
                ->visit('/rental/drivers')
                ->pause(1000)
                ->visit('/rental/drivers/1')
                ->screenshot('TCDriver003')
                ->visit('/rental/drivers')
                ->visit('/rental/drivers/2')
                ->screenshot('TCDriver004');
        });
    }
}
