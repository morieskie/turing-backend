<?php

use Illuminate\Http\Request;
use Turing\Backend\Http\Requests\BaseFormRequest;
use Turing\Shipping\Http\Controlllers\ShippingController;
use Turing\Shipping\Http\Resources\ShippingResource;
use Turing\Shipping\Model\Shipping;
use Turing\Shipping\Model\ShippingRegion;

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

// Get Shipping list
Route::get('/shipping/regions', function (BaseFormRequest $request) {
    return app(ShippingController::class)->index();
});

// Get shipping
Route::get('/shipping/regions/{shippingRegionId}', function (BaseFormRequest $request, int $shippingRegionId) {
    return app(ShippingController::class)->show($shippingRegionId);
});

// Get shipping
Route::get('/shipping/{shippingId}', function (BaseFormRequest $request, int $shippingId) {
    return app(ShippingController::class)->getShipping($shippingId);
});
