<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/add_product', function () {
    return view('add-product');
});

Route::view('/add/success', 'added-product');

Route::get('/catalog', 'ProductsController@index');
Route::get('/catalog/{q}', 'ProductsController@categories');
Route::get('/product/{id}', 'SingleProductController@index');

Route::get('/our_app', function () {
    return view('our-app');
});

Route::get('dashboard/approve', 'ProductsController@accept');

Route::get('/search', 'ProductsController@search');
Route::post('/add', 'ProductsController@add')->name('uploadfile');

// Route::get('/catalog', 'ProductsController@load_data');
// Route::post('/catalog/load_data', 'ProductsController@load_data')->name('loadmore.load_data');

