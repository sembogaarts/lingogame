<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserTest extends DuskTestCase
{
    /**
     * Tests if the user can change his/her username
     *
     * @return void
     */
    public function testUserCanChangeUsername()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Je speelt momenteel als gast')
                ->type('@username', 'Donald')
                ->click('@save')
                ->assertSee('Je speelt als Donald');
        });
    }

    /**
     * Tests if the user can change his/her username
     *
     * @return void
     */
    public function testUserCanStartGame()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->click('@newGame')
                ->click('@startGame')
                ->type('@word', 'holaa')
                ->click('@attempt')
                ->type('@word', 'holaa')
                ->click('@attempt')
                ->type('@word', 'holaa')
                ->click('@attempt')
                ->type('@word', 'holaa')
                ->click('@attempt')
                ->type('@word', 'holaa')
                ->click('@attempt')
                ->assertSee('Welk niveau wil je spelen?');
        });
    }

}
