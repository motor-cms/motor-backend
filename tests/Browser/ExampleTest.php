<?php

namespace Tests\Motor\Backend\Browser;

use Motor\Backend\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @throws \Throwable
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/backend')
                ->assertSee('Login');
        });
    }

    public function testLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(2))
                ->visit('/backend/dashboard')
                ->assertSee('Dashboard');
        });
    }
}
