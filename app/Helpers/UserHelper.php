<?php

namespace App\Helpers;

use App\Game;
use App\User;
use Illuminate\Support\Str;

class UserHelper
{

    private $_user;

    public function __construct($user)
    {
        $this->_user = $user;
    }

    public function isPlaying()
    {
        $latestGame = $this->getLatestGame();
        return isset($latestGame) && $latestGame->finished_at === null;
    }

    public function getLatestGame()
    {
        return Game::where([
            'user_id' => $this->_user->id
        ])->orderBy('id', 'desc')->first();
    }

}
