<?php

namespace App\Helpers;

use App\Attempt;
use App\Game;
use App\Round;
use App\User;
use App\Word;
use Carbon\Carbon;
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

    public function getWordLength() {
        return $this->_game->word_length;
    }

    public function getFirstLetterOfWord() {
        return $this->currentRound()->word[0];
    }

    public static function create($user, $wordLength)
    {

        $game = Game::create([
            'user_id' => $user->id,
            'word_length' => $wordLength
        ]);

        return new GameHelper($game);

    }

    public function currentRound() {
        $lastIndex = array_key_last($this->_rounds->toArray());
        return last($this->_rounds)[$lastIndex];
    }

    public function attemptsForCurrentRound() {
        return $this->currentRound()->attempts;
    }

    public function newRound()
    {
        $word = WordHelper::randomWord($this->_game->word_length);

        $round[] = Round::create([
            'game_id' => $this->_game->id,
            'word' => $word->word
        ]);

        return $this;

    }

    public function makeAttempt($word) {
        $attempt = Attempt::create([
            'round_id' => $this->currentRound()->id,
            'word' => strtolower($word)
        ]);
        return $attempt;
    }

    public function checkAttempt(Attempt $attempt) {
        return $this->currentRound()->word === $attempt->word;
    }

    public function stop() {
        $this->_game->finished_at = Carbon::now();
        $this->_game->score = $this->calculateScore();
        $this->_game->save();
    }

    public function calculateScore() {
        $points = 0;
        foreach($this->_rounds as $round) {
            if($round->success) {
                $points++;
            }
        }
        return $points;
    }

    public function finishRound(bool $success) {
        $round = $this->currentRound();
        $round->success = $success;
        $round->finished_at = Carbon::now();
        $round->save();
        return $round;
    }

}
