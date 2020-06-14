<?php

namespace App\Helpers;

use App\Attempt;
use App\Game;
use App\Round;
use Carbon\Carbon;

class GameHelper
{

    private $_game;
    private $_rounds;

    /**
     * GameHelper constructor.
     * @param $game
     */
    public function __construct($game)
    {
        // Set the game
        $this->_game = $game;
        // Get data for game
        $this->getRounds();
    }

    /**
     * Set the rounds for the game local
     */
    private function getRounds() {
        $this->_rounds = Round::where('game_id', $this->_game->id)->get();
    }

    /**
     * Returns the length of the words
     * @return integer
     */
    public function getWordLength() {
        return $this->_game->word_length;
    }

    /**
     * Returns the first letter of the word in the current round
     * @return string
     */
    public function getFirstLetterOfWord() {
        return $this->currentRound()->word[0];
    }

    /**
     * Creates a new game for the user and creates a new GameHelper class
     * @param $user
     * @param $wordLength
     * @return GameHelper
     */
    public static function create($user, $wordLength)
    {

        $game = Game::create([
            'user_id' => $user->id,
            'word_length' => $wordLength
        ]);

        return new GameHelper($game);

    }

    /**
     * Gets the current round
     * @return Round
     */
    public function currentRound() {
        $lastIndex = array_key_last($this->_rounds->toArray());
        return last($this->_rounds)[$lastIndex];
    }

    /**
     * Returns all the attempts for the current round
     * @return array
     */
    public function attemptsForCurrentRound() {
        return $this->currentRound()->attempts;
    }

    /**
     * Creates a new round for the game
     * @return $this
     */
    public function newRound()
    {
        $word = WordHelper::randomWord($this->_game->word_length);

        $round[] = Round::create([
            'game_id' => $this->_game->id,
            'word' => $word->word
        ]);

        return $this;

    }

    /**
     * Makes an attempt for the current round
     * @param $word
     * @return mixed
     */
    public function makeAttempt($word) {
        $attempt = Attempt::create([
            'round_id' => $this->currentRound()->id,
            'word' => strtolower($word)
        ]);
        return $attempt;
    }

    /**
     * Checks if the attempt is valid
     * @param Attempt $attempt
     * @return bool
     */
    public function checkAttempt(Attempt $attempt) {
        return $this->currentRound()->word === $attempt->word;
    }

    /**
     * @return $this
     */
    public function stop() {
        $this->_game->finished_at = Carbon::now();
        $this->_game->score = $this->calculateScore();
        $this->_game->save();
        return $this;
    }

    /**
     * Calculates the score for the current game
     * @return int
     */
    public function calculateScore() {
        $points = 0;
        foreach($this->_rounds as $round) {
            if($round->success) {
                $points++;
            }
        }
        return $points;
    }

    /**
     * Finish the current roundgi
     * @param bool $success
     * @return Round
     */
    public function finishRound(bool $success) {
        $round = $this->currentRound();
        $round->success = $success;
        $round->finished_at = Carbon::now();
        $round->save();
        return $round;
    }

}
