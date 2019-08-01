<?php

use Illuminate\Http\Request;
use Turing\Backend\Http\Requests\BaseFormRequest;
use Turing\Department\Http\Controlllers\DepartmentController;
use Turing\Department\Http\Resources\DepartmentCollection;
use Turing\Department\Http\Resources\DepartmentResource;
use Turing\Department\Model\Department;

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

// Get Department list
Route::get('/departments', function (BaseFormRequest $request) {
    return app(DepartmentController::class)->index();
});

// Get department
Route::get('/departments/{departmentId}', function (BaseFormRequest $request, int $departmentId) {
    return app(DepartmentController::class)->show($departmentId);
});
