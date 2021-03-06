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
    Route::get('profile', 'UserController@getProfile');

    Route::put('users', 'UserController@update');
    Route::post('auth/logout', 'AuthController@logout');


    Route::prefix('seller/application')->group(function(){
        Route::get('', 'SellerApplicationController@index');
        Route::post('', 'SellerApplicationController@store');
        Route::put('{id}', 'SellerApplicationController@update');
    });

    Route::prefix('sellers')->group(function (){
        Route::post('/validate', 'SellerController@isSeller');
        Route::get('/sellings', 'SellerController@getSelling');
        Route::get('/dashboard', 'DashboardController@index');
        Route::put('/{id}', 'SellerController@update');
    });

    Route::prefix('concerts')->group(function(){
        Route::post('/', 'ConcertController@store');
        Route::get('/history', 'ConcertController@getUserHistory');

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

    Route::prefix('referral')->group(function(){
        Route::get('/use', 'ReferralController@index');
        Route::get('/all', 'ReferralController@getAllReferralProgression');
        Route::get('/{id}', 'ReferralController@show');
        Route::post('/generate', 'ReferralController@store');
    });
});

Route::get('/plus-impression', 'ImpressionController@store');

Route::get('/homepage', 'DashboardController@homePage');

Route::prefix('auth')->group(function(){
    Route::post('login', 'AuthController@login');
});

Route::prefix('users')->group(function(){
    Route::post('register', 'UserController@register');
});

Route::get('genres', 'GenreController@index');

Route::prefix('sellers')->group(function (){
    Route::get('/', 'SellerController@index');
    Route::get('/{id}', 'SellerController@show');
});

Route::prefix('concerts')->group(function (){
    Route::get('/', 'ConcertController@index');
    Route::get('/{id}', 'ConcertController@show');
    Route::post('validation/token', 'TokenController@updateToken');
    Route::post('validation/session', 'TokenController@validateSession');
});
