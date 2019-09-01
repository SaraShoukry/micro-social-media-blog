<?php

use Illuminate\Http\Request;

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
Route::post('login', 'API\UserController@login')->middleware('localization');

Route::post('register', 'API\UserController@register')->middleware('localization');

Route::group(['middleware' => ['auth:api', 'localization']], function () {
    Route::post('logout', 'API\UserController@logout');
    Route::get('/', 'API\UserController@timeLine');
    Route::post('details', 'API\UserController@details');
});

Route::group(['middleware' => ['auth:api', 'localization'], 'prefix' => 'tweet'], function () {
    Route::post('/', 'API\TweetController@init');
    Route::delete('/{id}', 'API\TweetController@delete');
});

Route::group(['middleware' => ['auth:api', 'localization'], 'prefix' => 'follow'], function () {
    Route::post('/', 'API\FollowController@init');
});
