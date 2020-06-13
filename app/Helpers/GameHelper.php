<?php

namespace App\Helpers;

use App\Game;
use App\Round;
use App\User;
use App\Word;
use Carbon\Traits\Rounding;
use Illuminate\Support\Str;

class GameHelper
{

    private $_game;
    private $_rounds;

    public function __construct($game)
    {
        // Set the game
        $this->_game = $game;
        // Get data for game
        $this->getRounds();
    }

    private function getRounds() {
        $this->_rounds = Round::where('game_id', $this->_game->id)->get();
    }

    public static function create($user)
    {

        $game = Game::create([
            'user_id' => $user->id
        ]);

        return new GameHelper($game);

    }

    public function newRound($letters)
    {
        $word = WordHelper::randomWord($letters);

        $round[] = Round::create([
            'game_id' => $this->_game->id,
            'word' => $word->word
        ]);

        return $this;

    }

}
