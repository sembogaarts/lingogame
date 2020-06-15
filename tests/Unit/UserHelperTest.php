<?php

namespace Tests\Unit;

use App\Game;
use App\Helpers\GameHelper;
use App\Helpers\UserHelper;
use App\Round;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserHelperTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Check if the user is plaing
     *
     * @return void
     */
    public function testUserIsPlaying()
    {
        $user = factory(User::class)->create();

        $game = factory(Game::class)->create([
            'user_id' => $user->id,
            'word_length' => 5
        ]);

        $userHelper = new UserHelper($user);

        $this->assertTrue($userHelper->isPlaying());
    }

    /**
     * Check if the user's game is most recent
     *
     * @return void
     */
    public function testUserGame()
    {
        $user = factory(User::class)->create();

        $game1 = factory(Game::class)->create([
            'user_id' => $user->id,
            'word_length' => 5,
            'score' => 1,
            'finished_at' => Carbon::now()
        ]);

        $game2 = factory(Game::class)->create([
            'user_id' => $user->id,
            'word_length' => 5
        ]);

        $userHelper = new UserHelper($user);

        $this->assertFalse($userHelper->getLatestGame()->id === $game1->id);
        $this->assertTrue($userHelper->getLatestGame()->id === $game2->id);
    }
}
