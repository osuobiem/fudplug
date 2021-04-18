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
Route::get('', 'ViewController@feed')->name('.');

// LOGIC

// Vendor/User Login
Route::post('p-login', 'AuthController@login');

// Get Areas
Route::get('areas/{state_id}', 'AreaController@get');

// Get States
Route::get('states/{area_id?}', 'StateController@get');

// Update Location form onboarding
Route::get('location/{area_id}', 'AuthController@update_location');

// Email Verification Route
Route::get('verify/{token}', 'VerifyController@verify_email')->name('verify');

// Email Verification Resend Route
Route::post('verification/resend', 'VerifyController@verification_resend')->name('verification.resend');

// Display Page with Verification Message to User
Route::get('verify-email', 'ViewController@verify_page')->name('verify-email');

// Display Expired Link Page
Route::get('expired-link', 'ViewController@expired_link_page')->name('expired-link');

// Send Forgot Password Email
Route::post('forgot-password-email', 'ForgotPasswordController@send_mail')->name('forgot-password-email');

// Display Password Reset View
Route::get('reset-password/{token?}', 'ForgotPasswordController@show')->name('reset-password');

// Send Forgot Password Email
Route::post('update-password', 'ForgotPasswordController@update_password')->name('update-password');

// Socialite Auth Routes(GOOGLE)
Route::get('auth/google', 'Socialite\GoogleController@redirect_to_google');
Route::get('auth/google/callback', 'Socialite\GoogleController@handle_google_callback');

// Socialite Auth Routes(FACEBOOK)
Route::get('auth/facebook', 'Socialite\FacebookController@redirect_to_facebook');
Route::get('auth/facebook/callback', 'Socialite\FacebookController@handle_facebook_callback');

// VENDOR ROUTES
Route::group(['prefix' => 'vendor'], function () {

    // *** Open ***

    // Vendor Sign Up
    Route::post('sign-up', 'VendorController@sign_up');

    // *** Protected ***
    Route::group(['middleware' => ['auth']], function () {
        // Vendor Logout
        Route::get('logout', 'VendorController@logout');
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
        // Get orders
        Route::get('get-order/{type?}', 'VendorController@get_order');
        // Reject Order
        Route::get('reject-order/{order_id?}', 'VendorController@reject_order');
        // Accept Order
        Route::get('accept-order/{order_id?}', 'VendorController@accept_order');
        // Get order detail
        Route::get('get-order-detail/{order_id}', 'VendorController@get_order_detail');
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
        // Vendor Profile Page
        Route::get('vendor-profile/{vendor_id}', 'UserController@vendor_profile');
        // Order Details
        Route::get('order-details/{dish_id}/{dish_type?}', 'UserController@order_details');
        // Add to basket
        Route::post('add-to-basket', 'UserController@add_to_basket');
        // Get user basket data
        Route::get('get-basket', 'UserController@get_basket');
        // Remove from basket
        Route::post('delete-basket', 'UserController@delete_basket');
        // Update basket item quantity
        Route::post('update-basket', 'UserController@update_basket');
        // Place order
        Route::post('place-order', 'UserController@place_order');
        // Get user orders
        Route::get('get-order/{type?}', 'UserController@get_order');
        // Cancel Order
        Route::get('cancel-order/{order_id?}', 'UserController@cancel_order');
        // Rate Vendor
        Route::post('rate', 'UserController@rate');
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

        // Delete Post
        Route::get('delete/{post_id}', 'PostController@delete');
    });
});
// -------------

// COMMENT ROUTES
Route::group(['prefix' => 'comment'], function () {
    // Get Comments
    Route::get('get/{post_id}/{from?}/{id_is_comment?}', 'CommentController@get');

    // Create Comment
    Route::post('create/{post_id}', 'CommentController@create');

    // Delete Comment
    Route::get('delete/{comment_id}', 'CommentController@delete');
});
// -------------

// SOCKET ROUTES
Route::group(['prefix' => 'socket'], function () {
    // Save new socket_id
    Route::get('save-id/{username}/{socket_id}', 'SocketController@save_id');
});
// -------------

// NOTIFICATION ROUTES
Route::group(['prefix' => 'notification'], function () {
    // Get Notifications
    Route::get('get/{from?}', 'NotificationController@get');

    // Mark as read
    Route::get('mark-as-read/{id?}', 'NotificationController@mark_as_read');

    // Clear nviewed
    Route::get('clear-nviewed', 'NotificationController@clear_nviewed');

    // Register Web Push Subscription
    Route::post('register-wps', 'NotificationController@register_wps');
});
// -------------

// Vendor Profile
Route::get('{username}', 'ViewController@profile');
