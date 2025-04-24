<?php

namespace Tests\Motor\Backend\Browser;

use Laravel\Dusk\Browser;
use Motor\Backend\Models\User;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @throws \Throwable
     */
    public function test_basic_example()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/backend')
                ->assertSee('Login');
        });
    }

    public function test_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(2))
                ->visit('/backend/dashboard')
                ->assertSee('Dashboard');
        });
    }
}
