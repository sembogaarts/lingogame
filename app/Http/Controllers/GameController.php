<?php

namespace App\Http\Controllers;

use App\Game;
use App\Helpers\BoardHelper;
use App\Helpers\GameHelper;
use App\Helpers\UserHelper;
use App\Http\Requests\NewGameRequest;
use Firebit\Laravel\ApiResponse\ApiResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{

    public function newGame(Request $request)
    {
        $user = Auth::user();
        $userHelper = new UserHelper($user);

        if ($userHelper->isPlaying()) {
            return redirect()->route('playGame');
        }

        return view('new-game');

    }

    public function playGame()
    {
        $user = Auth::user();
        $userHelper = new UserHelper($user);

        if (!$userHelper->isPlaying()) {
            return redirect()->route('newGame');
        }

        $game = $userHelper->getLatestGame();

        $gameHelper = new GameHelper($game);

        $round = $gameHelper->currentRound();
        $attempts = $gameHelper->attemptsForCurrentRound();

        $boardHelper = new BoardHelper($game, $round, $attempts);

        $boardHelper->render();

        return view('play-game')
            ->with([
                'wordLength' => $gameHelper->getWordLength(),
                'rows' => $boardHelper->getRows(),
                'input' => $boardHelper->getInputRow()
            ]);

    }

    public function create(NewGameRequest $request)
    {

        $user = Auth::user();
        $userHelper = new UserHelper($user);

        if ($userHelper->isPlaying()) {
            return redirect()->route('game');
        }

        // Create a new game
        $gameHelper = GameHelper::create($user, $request->word_length);

        // Create new round for game
        $gameHelper->newRound();

        // Return the play game
        return redirect()->route('playGame');
    }


}
