<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testUserCanChangeUsername()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->type('@username', 'Sem')
                ->click('@save')
                ->assertSee('Sem');
        });
    }
}
