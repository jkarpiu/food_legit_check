<?php

use App\Http\Controllers\ProductsController;
use App\ToAddProduct;
use App\Product;
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

Auth::routes(['verify' => true]);

Route::view('/', 'home');
Route::get('/add_product', 'ApprovementsController@addSite')->name('add-product');
Route::view('/our_app', 'our-app');
Route::post('/our_app/rate', 'RateController@add')->name('rate');
Route::get('/our_app/download', function() {
    return redirect('flc.apk');
});
Route::get('/catalog', 'ProductsController@index');
Route::get('/catalog/{q}', 'ProductsController@categories');
Route::get('/product/{id}', 'ProductsController@find');
Route::get('product/{id}/edit', function($id) {
    if (Auth::user()) {
        $product = Product::find($id);
        if (Auth::user() -> role == 'Administrator' and Auth::user() -> email_verified_at != null) {
            return view('edit-product')->with('product', $product);
        } else {
            return redirect('/product/'.$id);
        }
    } else {
        return redirect('login');
    }
});
Route::post('edit-product', 'ProductsController@edit')->name('editProduct');
Route::get('/product/{id?}/delete', function ($id = null) {
    if (Auth::user()) {
        if (Auth::user()->role == 'Administrator' and Auth::user() -> email_verified_at != null) {
            return view('confirm_delete_product');
        } else {
            return redirect('/catalog');
        }
    } else {
        return redirect('login');
    }
});
Route::get('/product/{id?}/delete/confirmed', 'ProductsController@delete')->name('deleteProduct');
Route::get('/product/{id}/report', 'ProductsController@reportSite');
Route::post('report', 'ProductsController@report')->name('report');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::post('/dashboard/save', 'UserController@saveNote')->name('saveNote');
Route::get('dashboard/approve', 'ApprovementsController@index');
Route::get('dashboard/approve/{id}/edit', function($id) {
    if (Auth::user()) {
        $product = ToAddProduct::find($id);
        if (Auth::user() -> role == 'Administrator' or Auth::user() -> email_verified_at != null and Auth::user()->id == $product->user->id) {
            return view('edit-approvement')->with('product', $product);
        } else {
            return redirect('/dashboard/approve');
        }
    } else {
        return redirect('login');
    }
});
Route::get('dashboard/approve/{id}/add', 'ProductsController@add');
Route::get('dashboard/approve/{id}/undo', 'ApprovementsController@undo');
Route::get('dashboard/approve/{id}/delete', function($id = null) {
    if (Auth::user()) {
        if (ToAddProduct::find($id)->user->id == Auth::user()->id) {
            return view('confirm_delete_approvement');
        } else {
            return redirect('/dashboard/approve');
        }
    } else {
    return redirect('login');
    }
});

Route::get('dashboard/approve/{id}/delete/confirmed', 'ApprovementsController@delete');
Route::get('dashboard/approve/{id}', 'ApprovementsController@find');
Route::get('dashboard/account', 'UserController@options');
Route::get('/dashboard/account/edit', function() {
    if (Auth::user()) {
        return view('edit-user');
    } else {
        return redirect('/login');
    }
});
Route::get('/dashboard/account/delete', function() {
    if (Auth::user()) {
        return view('confirm_delete_account');
    } else {
        return redirect('/login');
    }
});
Route::get('dashboard/account/delete/confirmed', 'UserController@delete')->name('deleteUser');
Route::get('/dashboard/account/change-password', 'ChangePasswordController@index');
Route::post('change-password', 'ChangePasswordController@store')->name('change.password');
Route::post('edit-user', 'UserController@edit')->name('editUser');
Route::post('edit-approvement', 'ApprovementsController@edit')->name('editApprovement');
Route::get('/search', 'ProductsController@search');
Route::post('/add', 'ApprovementsController@add')->name('uploadfile');
