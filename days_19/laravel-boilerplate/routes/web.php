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

    // Products
    Route::get('products', 'ProductController@index')->name('products');
    Route::get('products/create', 'ProductController@create')->name('products.create');
    Route::post('products/create', 'ProductController@insert')->name('products.insert');
    Route::get('products/{id}/show', 'ProductController@show')->name('products.show');
    Route::get('products/{id}/edit', 'ProductController@edit')->name('products.edit');
    Route::any('products/{id}/destroy', 'ProductController@destroy')->name('products.destroy');
    Route::put('products/{id}/edit', 'ProductController@update')->name('products.update');

    // Suppliers
    Route::get('suppliers', 'SupplierController@index')->name('suppliers');
    Route::get('suppliers/create', 'SupplierController@create')->name('suppliers.create');
    Route::post('suppliers/create', 'SupplierController@insert')->name('suppliers.insert');
    Route::get('suppliers/{id}/show', 'SupplierController@show')->name('suppliers.show');
    Route::get('suppliers/{id}/edit', 'SupplierController@edit')->name('suppliers.edit');
    Route::any('suppliers/{id}/destroy', 'SupplierController@destroy')->name('suppliers.destroy');
    Route::put('suppliers/{id}/edit', 'SupplierController@update')->name('suppliers.update');

    // Customers
    Route::get('customers', 'CustomerController@index')->name('customers');
    Route::get('customers/create', 'CustomerController@create')->name('customers.create');
    Route::post('customers/create', 'CustomerController@insert')->name('customers.insert');
    Route::get('customers/{id}/show', 'CustomerController@show')->name('customers.show');
    Route::get('customers/{id}/edit', 'CustomerController@edit')->name('customers.edit');
    Route::any('customers/{id}/destroy', 'CustomerController@destroy')->name('customers.destroy');
    Route::put('customers/{id}/edit', 'CustomerController@update')->name('customers.update');
});

Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => 'User', 'middleware' => 'check.user'], function () {
    Route::get('/', 'DashboardUserController@index')->name('dashboard');
});

Route::group(['prefix' => 'purchase_orders', 'as' => 'purchase_orders.', 'namespace' => 'PurchaseOrder', 'middleware' => 'check.login'], function () {
    Route::get('', 'PurchaseOrderController@index')->name('index');
    Route::get('create', 'PurchaseOrderController@create')->name('create');
    Route::post('create', 'PurchaseOrderController@store')->name('create');
    Route::get('{id}', 'PurchaseOrderController@show')->name('show');
    Route::delete('destroy/{id}', 'PurchaseOrderController@destroy')->name('destroy');
});

Route::group(['prefix' => 'sales_orders', 'as' => 'sales_orders.', 'namespace' => 'SalesOrder', 'middleware' => 'check.login'], function () {
    Route::get('', 'SalesOrderController@index')->name('index');
    Route::get('create', 'SalesOrderController@create')->name('create');
    Route::post('create', 'SalesOrderController@store')->name('create');
    Route::get('{id}', 'SalesOrderController@show')->name('show');
    Route::delete('destroy/{id}', 'SalesOrderController@destroy')->name('destroy');
});


Route::group(['middleware' => 'check.login'], function () {
    Route::get('product_histories', 'ProductHistoryController@index')->name('product_histories.index');
});

Route::get('/', 'HomeController@index');
