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

    Route::prefix('seller/application')->group(function(){
        Route::get('', 'SellerApplicationController@index');
        Route::post('', 'SellerApplicationController@store');
        Route::put('{id}', 'SellerApplicationController@update');
    });

    Route::prefix('sellers')->group(function (){
        Route::get('/', 'SellerController@index');
        Route::get('/sellings', 'SellerController@getSelling');
        Route::get('/{id}', 'SellerController@show');
        Route::put('/{id}', 'SellerController@update');
    });

    Route::prefix('concerts')->group(function(){
        Route::post('/', 'ConcertController@store');
        Route::get('/history', 'ConcertController@getUserHistory');
        Route::get('/', 'ConcertController@index');
        Route::get('/{id}', 'ConcertController@show');
        Route::put('/{id}', 'ConcertController@update');
    });

    Route::prefix('tickets')->group(function(){
        Route::post('/', 'TicketController@store');
        Route::get('/', 'TicketController@index');
    });

    Route::prefix('reviews')->group(function(){
        Route::post('/', 'ReviewController@store');
    });

    Route::prefix('wallet')->group(function(){
        Route::get('/', 'WalletController@index');
        Route::post('/', 'WalletController@store');
    });

    Route::get('/referral/all/{user_id}', 'ReferralController@getAllReferralProgression');

});

Route::prefix('auth')->group(function(){
    Route::post('login', 'AuthController@login');
});

Route::prefix('users')->group(function(){
    Route::post('register', 'UserController@register');
});

Route::prefix('referral')->group(function(){
    Route::get('/{id}', 'ReferralController@index');
});

Route::get('genres', 'GenreController@index');
