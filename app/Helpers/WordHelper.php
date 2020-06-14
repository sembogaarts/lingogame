<?php

namespace App\Helpers;

use App\Game;
use App\User;
use App\Word;
use Illuminate\Support\Str;

class WordHelper
{

    public static function randomWord($letters)
    {
        return Word::where('length', $letters)
            ->inRandomOrder()
            ->first();
    }

}
