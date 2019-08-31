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
Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'API\UserController@logout');
    Route::post('details', 'API\UserController@details');
});
Route::group(['middleware' => 'auth:api', 'prefix'=>'tweet'], function () {
    Route::post('/', 'API\TweetController@init');
    Route::delete('/{id}','API\TweetController@delete');
//    Route::post('details', 'API\UserController@details');
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
