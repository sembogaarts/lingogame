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

    // New game screen
    Route::get('/new-game', 'GameController@newGame')->name('newGame');

    // Play game
    Route::get('/play', 'GameController@playGame')->name('playGame');

    Route::post('/game', 'GameController@create')->name('createGame');

    // Highscore
    Route::get('/highscore', 'HighscoreController@index');

});

