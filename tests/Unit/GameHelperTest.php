<?php

namespace Tests\Unit;

use App\Attempt;
use App\Game;
use App\Helpers\GameHelper;
use App\Round;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class GameHelperTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Test if the class gives the right first letter
     *
     * @return void
     */
    public function testCheckCurrentRound()
    {

        $user = factory(User::class)->create();

        $game = factory(Game::class)->create([
            'user_id' => $user->id,
            'word_length' => 5
        ]);

        $round = factory(Round::class)->create([
            'game_id' => $game->id,
            'word' => 'hallo'
        ]);

        $gameHelper = new GameHelper($game);

        $currentRound = $gameHelper->currentRound();

        $this->assertTrue($round->word === $currentRound->word);
    }

    public function testCheckRoundFinish() {

        $user = factory(User::class)->create();

        $game = factory(Game::class)->create([
            'user_id' => $user->id,
            'word_length' => 5
        ]);

        $round = factory(Round::class)->create([
            'game_id' => $game->id,
            'word' => 'hallo'
        ]);

        $gameHelper = new GameHelper($game);

        $round = $gameHelper->finishRound(true);

        $this->assertTrue($round->success);
    }

    public function testCalculateScore() {

        $user = factory(User::class)->create();

        $game = factory(Game::class)->create([
            'user_id' => $user->id,
            'word_length' => 5
        ]);

        $round = factory(Round::class)->create([
            'game_id' => $game->id,
            'word' => 'hallo',
            'success' => 1
        ]);

        $round = factory(Round::class)->create([
            'game_id' => $game->id,
            'word' => 'hallo',
            'success' => 1
        ]);

        $round = factory(Round::class)->create([
            'game_id' => $game->id,
            'word' => 'hallo',
            'success' => 0
        ]);

        $gameHelper = new GameHelper($game);

        $score = $gameHelper->calculateScore();

        $this->assertTrue($score === 2);
    }

    public function testMakeAttempt() {

        $user = factory(User::class)->create();

        $game = factory(Game::class)->create([
            'user_id' => $user->id,
            'word_length' => 5
        ]);

        $round = factory(Round::class)->create([
            'game_id' => $game->id,
            'word' => 'hallo'
        ]);

        $gameHelper = new GameHelper($game);

        $attempt = $gameHelper->makeAttempt('holaa');

        $this->assertTrue(isset($attempt->id));
    }

}
