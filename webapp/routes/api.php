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
Route::get('/get_catalog', "apiController@catalog");
Route::middleware('auth:api')->get('/get_history', "apiController@productsHistory");
Route::middleware('auth:api')->post('/report', 'apiController@report');
Route::get("/test", "apiController@test");
Route::get('/categories', 'apiController@categories');
