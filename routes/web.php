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

// LOGIC

// Vendor/User Login
Route::post('login', 'AuthController@login');

// Get Areas
Route::get('areas/{state_id}', 'AreaController@get');

// Update Location form onboarding
Route::get('location/{area_id}', 'AuthController@update_location');

// --------------

// **********************************************************

// VENDOR ROUTES
Route::group(['prefix' => 'vendor'], function () {

    // *** Open ***

    // Vendor Sign Up
    Route::post('sign-up', 'VendorController@sign_up');

    // *** Protected ***
    Route::group(['middleware' => ['auth']], function () {
        // Vendor Logout
        Route::get('logout', 'VendorController@logout');
        // Vendor Profile
        Route::get('profile', 'VendorController@profile');
        // Update Vendor Profile
        Route::post('profile_update', 'VendorController@update');
        // Change Profile Image
        Route::post('profile_image_update', 'VendorController@profile_image_update');
        // Change Cover Image
        Route::post('cover_image_update', 'VendorController@cover_image_update');
        // Add Dishes
        Route::post('add-dish', 'VendorController@add_dish');
        // Get Vendor Dishes
        Route::get('dish/{id?}', 'VendorController@get_dish');
    });
});
// -------------

// **********************************************************

// USER ROUTES
Route::group(['prefix' => 'user'], function () {

    // *** Open ***

    // User Sign Up
    Route::post('sign-up', 'UserController@sign_up');

    // *** Protected ***
    Route::group(['middleware' => ['auth:user']], function () {
        // User Logout
        Route::get('logout', 'UserController@logout');
    });
});
// -------------

// POST ROUTES
Route::group(['prefix' => 'post'], function () {
    // *** Protected ***
    Route::group(['middleware' => ['auth']], function () {
        // User Logout
        Route::post('create', 'PostController@post');
    });
});
// -------------
