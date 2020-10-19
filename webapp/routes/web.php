<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::view('/', 'home');
Route::view('/add_product', 'add-product');
Route::view('/our_app', 'our-app');

Route::get('/catalog', 'ProductsController@index');
Route::get('/catalog/{q}', 'ProductsController@categories');
Route::get('/product/{id}', 'ProductsController@singleProduct');

Route::get('dashboard/approve', 'ProductsController@approveList');
Route::get('dashboard/approve/{id}', 'ProductsController@singleApprove');
Route::get('dashboard/approve/{id}/delete', 'ProductsController@delete');

Route::get('dashboard/account', 'UserController@options');

Route::get('/search', 'ProductsController@search');
Route::post('/add', 'ProductsController@add')->name('uploadfile');
Route::post('/dashboard/save', 'UserController@saveNote')->name('saveNote');

// Route::get('/catalog', 'ProductsController@load_data');
// Route::post('/catalog/load_data', 'ProductsController@load_data')->name('loadmore.load_data');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
