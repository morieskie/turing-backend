<?php

use Illuminate\Http\Request;
use Turing\Backend\Http\Requests\BaseFormRequest;
use Turing\Product\Http\Controllers\ProductController;
use Turing\Product\Http\Requests\GetProductsInCategoryRequest;
use Turing\Product\Http\Requests\GetProductsInDepartmentRequest;
use Turing\Product\Http\Requests\GetProductsRequest;
use Turing\Product\Http\Requests\GetProductsSearchRequest;
use Turing\Product\Http\Requests\PostProductReviewRequest;

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

// Get Product list
Route::get('/products', function (GetProductsRequest $request) {
    return app(ProductController::class)->index($request);
});

// Get product
Route::get('/products/search', function (GetProductsSearchRequest $request) {
    return app(ProductController::class)->search($request);
});

// Get product
Route::get('/products/{productId}', function (BaseFormRequest $request, int $productId) {
    return app(ProductController::class)->show($productId,$request);
});

// Get a list of Products in category
Route::get('/products/inCategory/{categoryId}', function (GetProductsInCategoryRequest $request, int $categoryId) {
    return app(ProductController::class)->productsInCategory($categoryId,$request);
});

// Get a list of Products in category
Route::get('/products/inDepartment/{departmentId}', function (GetProductsInDepartmentRequest $request, int $departmentId) {
    return app(ProductController::class)->productsInDepartment($departmentId,$request);
});

// Get details of product
Route::get('/products/{productId}/details', function (BaseFormRequest $request, int $productId) {
    return app(ProductController::class)->details($productId,$request);
});

// Get locations of product
Route::get('/products/{productId}/locations', function (BaseFormRequest $request, int $productId) {
    return app(ProductController::class)->locations($productId,$request);
});

// Get reviews of product
Route::get('/products/{productId}/reviews', function (BaseFormRequest $request, int $productId) {
    return app(ProductController::class)->reviews($productId,$request);
});

// Get reviews of product
Route::post('/products/{productId}/reviews', function (PostProductReviewRequest $request, int $productId) {
    return app(ProductController::class)->review((int)$productId,$request);
})->middleware('jwt.verify');
