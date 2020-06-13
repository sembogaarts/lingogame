<?php

namespace App\Http\Controllers;

use App\Game;
use App\Helpers\GameHelper;
use App\Helpers\UserHelper;
use App\Http\Requests\NewGameRequest;
use Firebit\Laravel\ApiResponse\ApiResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{

    public function index(Request $request)
    {

        $user = Auth::user();
        $userHelper = new UserHelper($user);

        if($userHelper->isPlaying()) {
            return view('play');
        } else {
            return view('game');
        }

    }

    public function create(NewGameRequest $request)
    {

        $user = Auth::user();
        $userHelper = new UserHelper($user);

        if ($userHelper->isPlaying()) {
            return redirect()->route('game');
        }

        // Create a new game
        $gameHelper = GameHelper::create($user);

        // Create new round for game
        $gameHelper->newRound($request->letters);

        // Return the play game
        return redirect()->route('game');
    }


}
