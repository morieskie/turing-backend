<?php

use Illuminate\Http\Request;
use Turing\Customer\Http\Controllers\CustomerController;
use Turing\Customer\Http\Requests\GetCustomerRequest;
use Turing\Customer\Http\Requests\PostCustomerFacebookRequest;
use Turing\Customer\Http\Requests\PostCustomerLoginRequest;
use Turing\Customer\Http\Requests\PostCustomerRegisterRequest;
use Turing\Customer\Http\Requests\PutCustomerAddressRequest;
use Turing\Customer\Http\Requests\PutCustomerCreditCardRequest;
use Turing\Customer\Http\Requests\PutCustomerRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Update Customer
Route::put('/customer', function (PutCustomerRequest $request) {
    return app(CustomerController::class)->update($request);
})->middleware('jwt.verify');

// Update Customer by ID by using accessToken
Route::get('/customer', 'CustomerController@getAuthenticatedUser')->middleware('jwt.verify');

// Register a customer
Route::post('/customers', function (PostCustomerRegisterRequest $request) {
    return app(CustomerController::class)->create();
});

// Sign-in in the Shopping
Route::post('/customers/login', function (PostCustomerLoginRequest $request) {
    return app(CustomerController::class)->authenticate($request);
});

// Sign-in in the Shopping
Route::post('/customers/facebook', function (PostCustomerFacebookRequest $request) {
    return app(CustomerController::class)->authenticateFacebook($request);
});

// Update customer address
Route::put('/customers/address', function (PutCustomerAddressRequest $request) {
    return app(CustomerController::class)->updateAddress();
})->middleware('jwt.verify');

// Update customer credit card
Route::put('/customers/creditCard', function (PutCustomerCreditCardRequest $request) {
    return app(CustomerController::class)->updateCreditCard();
})->middleware('jwt.verify');

