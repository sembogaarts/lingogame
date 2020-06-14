<?php

namespace App\Helpers;

use App\Attempt;
use App\Enums\LetterStatus;
use App\User;
use Illuminate\Support\Str;

class BoardHelper
{

    private $_game;
    private $_round;
    private $_attempts;
    private $_rows = [];
    private $_input = [];


    /**
     * BoardHelper constructor.
     * @param $game
     * @param $round
     * @param $attempts
     */
    public function __construct($game, $round, $attempts)
    {
        $this->_game = $game;
        $this->_round = $round;
        $this->_attempts = $attempts;
    }

    /**
     * Render the board for the view
     * @return $this
     */
    public function render()
    {
        // Foreach attempt render a row
        foreach ($this->_attempts as $attempt) {
            // Get feedback for the row
            $row = $this->renderAttempt($attempt);
            $this->_rows[] = $row;
        }
        // Render's the user's input row
        $this->inputRow();
        return $this;
    }

    /**
     * Returns the rows with the previous attempts
     * @return array
     */
    public function getRows()
    {
        return $this->_rows;
    }

    /**
     * Returns the row with the input for the user
     * @return array
     */
    public function getInputRow()
    {
        return $this->_input;
    }

    /**
     * Fills the input row with al the previous attempts
     * @return void
     */
    private function inputRow()
    {
        // Always give the first letter away
        $this->_input[0] = $this->_round->word[0];
        // Check for each attempt the letters
        foreach ($this->_rows as $row) {
            for ($i = 0; $i < $this->_game->word_length; $i++) {
                if ($row['status'][$i] === LetterStatus::Correct) {
                    $this->_input[$i] = $this->_round->word[$i];
                }
            }
        }
    }

    /**
     * Renders a row for the attempts
     * @param Attempt $attempt
     * @return array
     */
    private function renderAttempt(Attempt $attempt)
    {
        // Put words in arrays
        $correctWord = $this->stringToArray($this->_round->word);
        $attemptWord = $this->stringToArray($attempt->word);
        // First remove all valid letters
        $feedback = $this->getValidLetterPositions($correctWord, $attemptWord);
        // Remove valid letters
        $correctWord = $this->removeLettersAtIndexes($correctWord, $feedback);
        $attemptWord = $this->removeLettersAtIndexes($attemptWord, $feedback);
        //
        $feedback = $this->getMisplacedLetterPositions($correctWord, $attemptWord, $feedback);
        // Reorder the array
        ksort($feedback);
        // Returns the
        return [
            'word' => $this->stringToArray($attempt->word),
            'status' => $feedback
        ];
    }

    /**
     * Converts a string to an array
     * @param $str
     * @return array
     */
    private function stringToArray($str)
    {
        return str_split($str, 1);
    }

    /**
     * Removes letters from certain indexes
     * Used to check what letters are misplaced or already correct
     * @param $word
     * @param $feedback
     * @return mixed
     */
    private function removeLettersAtIndexes($word, $feedback)
    {
        for ($i = 0; $i < $this->_game->word_length; $i++) {
            if (isset($feedback[$i])) {
                $word[$i] = null;
            }
        }
        return $word;
    }

    /**
     * Get all positions for the letters that are already valid
     * @param $correctWord
     * @param $attemptWord
     * @return array
     */
    private function getValidLetterPositions($correctWord, $attemptWord)
    {
        $feedback = [];
        // Loop trough all letters in the word
        for ($i = 0; $i < $this->_game->word_length; $i++) {
            // Remove all valid letters
            if ($correctWord[$i] === $attemptWord[$i]) {
                // Letter is matching
                $feedback[$i] = LetterStatus::Correct;
            }
        }
        return $feedback;
    }

    /**
     * @param $correctWord
     * @param $attemptWord
     * @param $feedback
     * @return mixed
     */
    private function getMisplacedLetterPositions($correctWord, $attemptWord, $feedback)
    {
        $misplaced = [];
        // Loop trough all letters in the word
        for ($i = 0; $i < $this->_game->word_length; $i++) {
            if (isset($attemptWord[$i])) {
                // Remove all valid letters

                // Check how many times the letter is in the correct word
                $positionsInCorrectWord = array_keys($correctWord, $attemptWord[$i]);
                $letterCountInCorrectWord = count($positionsInCorrectWord);

                // Check howmany letters aare in the wrong position
                $positionsInWrongPositions = array_keys($misplaced, $attemptWord[$i]);
                $countInWrongPositions = count($positionsInWrongPositions);

                if ($letterCountInCorrectWord > $countInWrongPositions) {
                    // Letter is matching
                    $feedback[$i] = LetterStatus::WrongPosition;
                    $misplaced[] = $attemptWord[$i];
                } else {
                    $feedback[$i] = LetterStatus::Incorrect;
                }


            }
        }
        return $feedback;
    }

}
