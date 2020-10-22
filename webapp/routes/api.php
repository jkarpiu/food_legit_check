<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});

Route::get("/search", "apiController@shortSearch");
Route::get('/get_product', "apiController@get");
Route::middleware('auth:api')->get('/get_history', "apiController@productsHistory");
Route::get("/test", "apiController@test");
