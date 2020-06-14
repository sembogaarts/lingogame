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


    public function __construct($game, $round, $attempts)
    {
        $this->_game = $game;
        $this->_round = $round;
        $this->_attempts = $attempts;
    }

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

    public function getRows()
    {
        return $this->_rows;
    }

    public function getInputRow()
    {
        return $this->_input;
    }

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

    private function stringToArray($str)
    {
        return str_split($str, 1);
    }

    private function removeLettersAtIndexes($word, $feedback)
    {
        for ($i = 0; $i < $this->_game->word_length; $i++) {
            if (isset($feedback[$i])) {
                $word[$i] = null;
            }
        }
        return $word;
    }

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
