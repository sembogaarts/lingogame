<?php

namespace App\Http\Controllers;

use App\Game;
use App\Helpers\UserHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index(Request $request) {

        $user = Auth::user();

        $userHelper = new UserHelper($user);

        $games = Game::where([
            ['user_id', $user->id],
            ['finished_at', '!=', null]
        ])->get();

        return view('index')
            ->with('games', $games)
            ->with('active_game', $userHelper->isPlaying());
    }

}
