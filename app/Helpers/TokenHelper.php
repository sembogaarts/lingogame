<?php

namespace App\Helpers;

use App\User;
use Illuminate\Support\Str;

class TokenHelper
{

    public static function tokenExists($request)
    {
        if (TokenHelper::retrieveToken($request)) {
            return true;
        } else {
            return false;
        }
    }

    public static function retrieveToken($request) {
        return $request->cookie('token');
    }

    public static function newToken() {
        // Generate a new token
        $token = Str::random(40);
        // Check if the token does not exists
        $user = User::where('token', $token)->first();
        // Return if unique
        if($user) {
            return TokenHelper::newToken();
        } else {
            return $token;
        }
    }

}
