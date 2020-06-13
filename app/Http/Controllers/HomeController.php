<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index(Request $request) {

        $user = Auth::user()->with('games');

        return view('index');
    }

}
