<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\roleMiddleware;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');
});

Route::post("register", 'App\Http\Controllers\UserController@registerUser');

Route::group([
    'middleware' => 'api',
    'prefix' => 'suppliers'
], function ($router) {
    Route::get("/", 'App\Http\Controllers\SuppliersController@getAllSuppliers');
    Route::get("/{supplier}", 'App\Http\Controllers\SuppliersController@getSupplierById');
    Route::post("/insert", 'App\Http\Controllers\SuppliersController@insertSupplier');
    Route::put("/{supplier}/update", 'App\Http\Controllers\SuppliersController@updateSupplier');
    Route::delete("/{supplier}/delete", 'App\Http\Controllers\SuppliersController@deleteSupplier');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'customers'
], function ($router) {
    Route::get("/", 'App\Http\Controllers\CustomersController@getAllCustomers');
    Route::get("/{supplier}", 'App\Http\Controllers\CustomersController@getCustomerById');
    Route::post("/insert", 'App\Http\Controllers\CustomersController@insertCustomer');
    Route::put("/{supplier}/update", 'App\Http\Controllers\CustomersController@updateCustomer');
    Route::delete("/{supplier}/delete", 'App\Http\Controllers\CustomersController@deleteCustomer');
});


