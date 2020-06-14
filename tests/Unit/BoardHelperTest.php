<?php

namespace Tests\Unit;

use App\Attempt;
use App\Game;
use App\Helpers\BoardHelper;
use App\Helpers\GameHelper;
use App\Round;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class BoardHelperTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Test if the class gives the right first letter
     *
     * @return void
     */
    public function testInputRow()
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

        $attempt = factory(Attempt::class)->create([
            'round_id' => $round->id,
            'word' => 'holaa'
        ]);

        $gameHelper = new BoardHelper($game, $round, [$attempt]);

        $score = $gameHelper->render();

        $input = $score->getInputRow();

        $expectedInput = [
            0 => 'h',
            2 => 'l'
        ];

        $this->assertTrue($input === $expectedInput);
    }

}
