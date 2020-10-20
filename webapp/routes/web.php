<?php

use App\ToAddProduct;
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

Route::get('dashboard/approve', 'ApprovementsController@index');
Route::get('dashboard/approve/{id}/edit', function($id) {
    $product = ToAddProduct::find($id);
    return view('edit-approvement')->with('product', $product);
});
Route::post('edit-approvement', 'ApprovementsController@edit')->name('editApprovement');
Route::get('dashboard/approve/{id}/delete', 'ApprovementsController@delete');
Route::get('dashboard/approve/{id}', 'ApprovementsController@find');


Route::get('dashboard/account', 'UserController@options');
Route::view('/dashboard/account/edit', 'edit-user');
Route::post('edit-user', 'UserController@edit')->name('editUser');
Route::view('/dashboard/account/delete', 'confirm_delete_account');
Route::get('dashboard/account/delete/confirmed', function () {
    Auth::user()->delete();
    return redirect('/');
})->name('deleteUser');
Route::get('/dashboard/account/change-password', 'ChangePasswordController@index');
Route::post('change-password', 'ChangePasswordController@store')->name('change.password');

Route::get('/search', 'ProductsController@search');
Route::post('/add', 'ProductsController@add')->name('uploadfile');
Route::post('/dashboard/save', 'UserController@saveNote')->name('saveNote');

// Route::get('/catalog', 'ProductsController@load_data');
// Route::post('/catalog/load_data', 'ProductsController@load_data')->name('loadmore.load_data');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
