<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->namespace('Api')->name('api.v1.')->group(function() {
    Route::post('gameMaps', 'GameMapsController@store')->name('gameMaps.store');
    Route::get('gameMaps/{gameMap}', 'GameMapsController@show')->name('gameMaps.show');
    Route::get('gameMaps/level/{level}', 'GameMapsController@level')->name('gameMaps.level');
});
