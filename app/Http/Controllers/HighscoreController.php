<?php

namespace App\Http\Controllers;

use App\Helpers\HighscoreHelper;
use Illuminate\Http\Request;

class HighscoreController extends Controller
{
    public function index() {

        // Get all highscores
        $gamesWith5Letters = HighscoreHelper::getBest5LettersGames(5);
        $gamesWith6Letters = HighscoreHelper::getBest6LettersGames(5);
        $gamesWith7Letters = HighscoreHelper::getBest7LettersGames(5);

        // Return the view
        return view('highscores')
        ->with('easy', $gamesWith5Letters)
        ->with('medium', $gamesWith6Letters)
        ->with('hard', $gamesWith7Letters);
    }
}
