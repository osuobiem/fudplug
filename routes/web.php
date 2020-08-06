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

// GENERIC ROUTES

// UI
Route::get('', 'ViewController@feed');

// --------------

// **********************************************************

// VENDOR ROUTES
Route::group(['prefix' => 'vendor'], function () {

  // No Auth

  // Vendor Sign Up
  Route::post('sign-up', 'VendorController@sign_up');

  // -----------

});
// -------------

// **********************************************************

// USER ROUTES
Route::group(['prefix' => 'user'], function () {

  // No Auth

  // User Sign Up
  Route::post('sign-up', 'UserController@sign_up');

  // -----------

});
// -------------
