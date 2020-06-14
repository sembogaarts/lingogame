<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Concerns\AttachToken;
use Tests\TestCase;

class GameTest extends TestCase
{

    use AttachToken;

    public function testCanCreateGame()
    {
        // Create a user
        $user = factory(User::class)->create();

        // Send request to start a new game
        $response = $this->setUser($user)->get('/');

        $response->assertStatus(200);
    }
}
