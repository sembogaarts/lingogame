<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['token'])->group(function () {

    // Home for user
    Route::get('/', 'HomeController@index');

    // Route for creating a new game
    Route::post('/username', 'UserController@saveUsername')->name('saveUsername');

    // Route to see highscores
    Route::get('/highscores', 'HighscoreController@index');

    Route::middleware(['not-playing'])->group(function() {

        // Route with form for creating a new game
        Route::get('/new-game', 'GameController@newGame')->name('newGame');

        // Route for creating a new game
        Route::post('/new-game', 'GameController@create')->name('createGame');

    });

    Route::middleware(['playing'])->group(function() {

        // Route for the active game
        Route::get('/play', 'GameController@playGame')->name('playGame');

        // Route to attempt a word for active game
        Route::post('/attempt', 'GameController@attempt')->name('attempt');

        // Route to attempt a word for active game
        Route::post('/round', 'GameController@round')->name('round');

    });

});

