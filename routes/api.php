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

Route::middleware('auth:api')->group(function (){
    Route::put('users', 'UserController@update');
    Route::post('auth/logout', 'AuthController@logout');

    Route::post('seller/application', 'SellerApplicationController@store');

});

Route::prefix('auth')->group(function(){
    Route::post('login', 'AuthController@login');
});

Route::prefix('users')->group(function(){
    Route::post('register', 'UserController@register');
});
