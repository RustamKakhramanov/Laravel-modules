<?php
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

Route::prefix('me/articles')->group( function() {
    Route::get('/{id}', 'BlogController@show')->middleware('auth:api');

    Route::post('/', 'BlogController@store')->middleware('auth:api');
    Route::put('/{id}', 'BlogController@update')->middleware('auth:api');
    Route::delete('/{id}', 'BlogController@delete')->middleware('auth:api');

});

Route::get('/', 'BlogController@list')->middleware('auth:api');
