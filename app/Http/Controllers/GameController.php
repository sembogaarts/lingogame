<?php

namespace App\Http\Controllers;

use App\Attempt;
use App\Game;
use App\Helpers\BoardHelper;
use App\Helpers\GameHelper;
use App\Helpers\UserHelper;
use App\Http\Requests\AttemptRequest;
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
        return view('new-game');
    }

    public function playGame()
    {
        $user = Auth::user();
        $userHelper = new UserHelper($user);
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
                'input' => $boardHelper->getInputRow(),
                'round' => $round
            ]);

    }

    public function create(NewGameRequest $request)
    {

        $user = Auth::user();
        $userHelper = new UserHelper($user);

        // Create a new game
        $gameHelper = GameHelper::create($user, $request->length);



        // Create new round for game
        $gameHelper->newRound();

        // Return the play game
        return redirect()->route('playGame');
    }

    public function attempt(AttemptRequest $request) {

        $userHelper = new UserHelper(Auth::user());
        $gameHelper = new GameHelper($userHelper->getLatestGame());

        if($gameHelper->currentRound()->finished_at) {
            return redirect()
                ->route('playGame')
                ->with('message', 'Ronde is afgelopen, start een nieuwe ronde.');
        }

        $attempt = $gameHelper->makeAttempt($request->word);

        if($gameHelper->checkAttempt($attempt)) {
            $gameHelper->finishRound(true);
        } else {
            if(count($gameHelper->attemptsForCurrentRound()) >= 5) {
                $gameHelper->finishRound(false);
                $gameHelper->stop();
            }
        }

        return redirect()->route('playGame');

    }

    public function round() {

        $userHelper = new UserHelper(Auth::user());
        $gameHelper = new GameHelper($userHelper->getLatestGame());

        if($gameHelper->currentRound()->finished_at) {
            $gameHelper->newRound();
        }

        return redirect()->route('playGame');

    }

}
