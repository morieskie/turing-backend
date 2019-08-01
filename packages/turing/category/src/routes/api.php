<?php

use Turing\Backend\Http\Requests\BaseFormRequest;
use Turing\Category\Http\Controllers\CategoryController;
use Turing\Category\Http\Resources\CategoryCollection;

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

// Get Category list
Route::get('/categories', function (BaseFormRequest $request) {
    return app(CategoryController::class)->index();
});

// Get category
Route::get('/categories/{categoryId}', function (BaseFormRequest $request, int $categoryId) {
    return app(CategoryController::class)->show($categoryId);
});

// Get Categories of a ProductResource
Route::get('/categories/inProduct/{productId}', function (BaseFormRequest $request, int $productId) {
    return app(CategoryController::class)->getCategoriesInProduct($productId);
});

// Get Categories of a Department
Route::get('/categories/inDepartment/{departmentId}', function (BaseFormRequest $request, int $departmentId) {
    return app(CategoryController::class)->getCategoriesInDepartment($departmentId);
});
