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
Route::post('p-login', 'AuthController@login');

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
        // Get Vendor Dish & Populate RightSidebar
        Route::get('dish/{id?}', 'VendorController@get_dish');
        // Get Dish To Delete
        Route::get('dish-delete/{id}', 'VendorController@dish_delete');
        // Delete Dish
        Route::get('delete-dish/{id}', 'VendorController@delete_dish');
        // Update Vendor Dish
        Route::post('update-dish', 'VendorController@update_dish');
        // Populate Vendor Menu Select Modal
        Route::get('menu', 'VendorController@get_menu');
        // Update Vendor Menu
        Route::post('update-menu', 'VendorController@update_menu');
        // Get Vendor Menu
        Route::get('get-menu/{vendor_id?}', 'VendorController@main_menu');
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
        // User Profile
        Route::get('profile/{type}', 'UserController@profile');
        // Change Profile Image
        Route::post('profile-image-update', 'UserController@profile_image_update');
        // Get User Profile Edit Modal
        Route::get('profile-edit', 'UserController@profile_edit');
        // Update User Profile
        Route::post('update-profile', 'UserController@update_profile');
        // Update User Password
        Route::post('update-password', 'UserController@update_password');
        // Get Nearby Vendors
        Route::get('get-vendors', 'UserController@get_vendor');
        // Get All Vendors
        Route::get('all-vendors', 'UserController@all_vendors');
    });
});
// -------------

// POST ROUTES
Route::group(['prefix' => 'post'], function () {
    // Get Posts
    Route::get('get', 'PostController@get');

    // Like Post
    Route::get('like/{post_id}', 'PostController@like');

    // Unlike Post
    Route::get('unlike/{post_id}', 'PostController@unlike');

    // *** Protected ***
    Route::group(['middleware' => ['auth']], function () {
        // Create Post
        Route::post('create', 'PostController@create');
    });
});
// -------------

// COMMENT ROUTES
Route::group(['prefix' => 'comment'], function () {
    // Get Comments
    Route::get('get/{post_id}/{from?}', 'CommentController@get');

    // Create Comment
    Route::post('create/{post_id}', 'CommentController@create');

    // Delete Comment
    Route::get('delete/{comment_id}', 'CommentController@delete');
});
// -------------
