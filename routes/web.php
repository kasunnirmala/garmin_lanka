<?php

use Illuminate\Support\Facades\Artisan;
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
//
//Route::get('/user', 'UserController@index');
Route::get('/', function () {
    return redirect('/login');
});


Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/admin/view', 'adminController\viewController@index')->name("admin_view");
    Route::get('/admin/add', 'adminController\addController@index')->name("admin_add");
    Route::post('/admin/addVendor', 'adminController\addController@addVendor');
    Route::post('/admin/getProduct', 'adminController\addController@getProduct');
    Route::post('/admin/addItems', 'adminController\addController@addItems');
});


//Route::get('/admin/view', 'adminController\viewController@index')->name("admin_view");
//Route::get('/admin/add', 'adminController\addController@index');
//Route::post('/admin/addVendor', 'adminController\addController@addVendor');
//Route::post('/admin/getProduct', 'adminController\addController@getProduct');
//Route::post('/admin/addItems', 'adminController\addController@addItems');


Route::group(['middleware' => ['auth', 'sales']], function () {
    Route::get('/sales/view', 'salesController\stockoutController@index')->name("sales_view");
    Route::post('/sales/addCustomer', 'salesController\stockoutController@addCustomer');
    Route::post('/sales/getItem', 'salesController\stockoutController@getItem');
    Route::post('/sales/stockOut', 'salesController\stockoutController@stockOut');
});


//Route::get('/sales/view', 'salesController\stockoutController@index')->name("sales_view");
//Route::post('/sales/addCustomer', 'salesController\stockoutController@addCustomer');
//Route::post('/sales/getItem', 'salesController\stockoutController@getItem');
//Route::post('/sales/stockOut', 'salesController\stockoutController@stockOut');


Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);
