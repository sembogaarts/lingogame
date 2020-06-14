<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveUsernameRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function saveUsername(SaveUsernameRequest $request) {
        $user = Auth::user();
        $user->username = $request->username;
        $user->save();
        return redirect()->back();
    }
}
