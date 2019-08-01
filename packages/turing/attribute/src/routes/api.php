<?php

use Illuminate\Http\Request;
use Turing\Attribute\Http\Controllers\AttributeController;
use Turing\Attribute\Http\Resources\AttributeResource;
use Turing\Attribute\Http\Resources\AttributeValueResource;
use Turing\Attribute\Model\Attribute;
use Turing\Backend\Http\Requests\BaseFormRequest;

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

// Get Attribute list
Route::get('/attributes', function (BaseFormRequest $request) {
    return app(AttributeController::class)->index();
});

// Get attribute
Route::get('/attributes/{attributeId}', function (BaseFormRequest $request, int $attributeId) {
    return app(AttributeController::class)->show($attributeId);
});

// Get Values Attribute from Attribute
Route::get('/attributes/values/{attributeId}', function (BaseFormRequest $request, int $attributeId) {
    return app(AttributeController::class)->getAttributeValues($attributeId);
});

// Get All Attribute with Product ID
Route::get('/attributes/inProduct/{productId}', function (BaseFormRequest $request, int $productId) {
    return app(AttributeController::class)->getAttributesInProduct($productId);
});
