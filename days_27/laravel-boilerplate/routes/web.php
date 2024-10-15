<?php

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


/**
 * Auth routes
 */

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Auth'], function () {

    // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::get('logout', 'LoginController@logout')->name('logout');

    // Registration Routes...
    if (config('auth.users.registration')) {
        Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'RegisterController@register');
    }

    // Password Reset Routes...
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset');

    // Confirmation Routes...
    if (config('auth.users.confirm_email')) {
        Route::get('confirm/{user_by_code}', 'ConfirmController@confirm')->name('confirm');
        Route::get('confirm/resend/{user_by_email}', 'ConfirmController@sendEmail')->name('confirm.send');
    }

    // Social Authentication Routes...
    Route::get('social/redirect/{provider}', 'SocialLoginController@redirect')->name('social.redirect');
    Route::get('social/login/{provider}', 'SocialLoginController@login')->name('social.login');
});

/**
 * Backend routes
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {

    // Dashboard
    Route::get('/', 'DashboardController@index')->name('dashboard');

    //Users
    Route::get('users', 'UserController@index')->name('users');
    Route::get('users/restore', 'UserController@restore')->name('users.restore');
    Route::get('users/{id}/restore', 'UserController@restoreUser')->name('users.restore-user');
    Route::get('users/{user}', 'UserController@show')->name('users.show');
    Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit');
    Route::put('users/{user}', 'UserController@update')->name('users.update');
    Route::any('users/{id}/destroy', 'UserController@destroy')->name('users.destroy');
    Route::get('permissions', 'PermissionController@index')->name('permissions');
    Route::get('permissions/{user}/repeat', 'PermissionController@repeat')->name('permissions.repeat');
    Route::get('dashboard/log-chart', 'DashboardController@getLogChartData')->name('dashboard.log.chart');
    Route::get('dashboard/registration-chart', 'DashboardController@getRegistrationChartData')->name('dashboard.registration.chart');
});


Route::get('/', 'HomeController@index')->name('home');

/**
 * Membership
 */
Route::group(['as' => 'protection.'], function () {
    Route::get('membership', 'MembershipController@index')->name('membership')->middleware('protection:' . config('protection.membership.product_module_number') . ',protection.membership.failed');
    Route::get('membership/access-denied', 'MembershipController@failed')->name('membership.failed');
    Route::get('membership/clear-cache/', 'MembershipController@clearValidationCache')->name('membership.clear_validation_cache');
});


Route::group(['prefix' => 'posts', 'middleware' => 'check.auth'], function () {
    Route::get('/', 'PostController@index')->name('posts.index');
    Route::get('/create', 'PostController@create')->name('posts.create');
    Route::post('/create', 'PostController@store')->name('posts.store');
    Route::get('/update/{id}', 'PostController@edit')->name('posts.edit');
    Route::put('/update/{id}', 'PostController@update')->name('posts.update');
    Route::any('/delete/{id}', 'PostController@destroy')->name('posts.destroy');
    Route::get('/show/{id}', 'PostController@show')->name('posts.show');
});

Route::group(['prefix' => 'categories', 'middleware' => 'admin'], function () {
    Route::get('/', 'CategoryController@index')->name('categories.index');
    Route::get('/create', 'CategoryController@create')->name('categories.create');
    Route::post('/create', 'CategoryController@store')->name('categories.store');
    Route::get('/update/{id}', 'CategoryController@edit')->name('categories.edit');
    Route::put('/update/{id}', 'CategoryController@update')->name('categories.update');
    Route::any('/delete/{id}', 'CategoryController@destroy')->name('categories.destroy');
});

Route::post('posts/comments/{postId}', 'CommentController@store')->middleware('check.auth')->name('comments.store');
Route::any('/comments/{id}', 'CommentController@destroy')->middleware('check.auth')->name('comments.destroy');

// Route::post('/2fa', function () {
//     return redirect(URL()->previous());
// })->name('2fa')->middleware('2fa');

// Route::get('tes/2fa', 'MembershipController@index')->name('tes.2fa')->middleware(['auth', '2fa']);

// Route::get('/complete-registration', 'Auth\RegisterController@showCompleteRegistration')->name('complete.registration');
// Route::post('/complete-registration', 'Auth\RegisterController@completeRegistration')->name('complete.registration');
