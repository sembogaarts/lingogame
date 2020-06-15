<?php

namespace App\Helpers;

use App\Game;

class HighscoreHelper
{

    public static function getBest5LettersGames($amount)
    {
        return HighscoreHelper::getGames($amount, 5);
    }


    public static function getBest6LettersGames($amount)
    {
        return HighscoreHelper::getGames($amount, 6);
    }


    public static function getBest7LettersGames($amount)
    {
        return HighscoreHelper::getGames($amount, 7);
    }

    private static function getGames($amount, $word_length)
    {
        return Game::where([
            ['word_length', $word_length],
            ['score', '!=', null]
        ])->orderBy('score', 'desc')
            ->get()
            ->take($amount);
    }

}
