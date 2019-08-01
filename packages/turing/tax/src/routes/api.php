<?php

use Turing\Backend\Http\Requests\BaseFormRequest;
use Turing\Tax\Http\Controlllers\TaxController;

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

// Get TaxResource list
Route::get('/tax', function (BaseFormRequest $request) {
    return app(TaxController::class)->index();
});

// Get tax
Route::get('/tax/{taxId}', function (BaseFormRequest $request, int $taxId) {
    return app(TaxController::class)->show($taxId);
});
