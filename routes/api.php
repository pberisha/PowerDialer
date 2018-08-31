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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->prefix('admin')->group(function () {
    Route::post('/callcenters', 'APIAccessController@callcenters');
    Route::post('/callcenters/password', 'APIAccessController@setPassword');
    Route::post('/callcenters/delete', 'APIAccessController@userDelete');
    Route::post('/callcenters/add', 'APIAccessController@addUser');
});