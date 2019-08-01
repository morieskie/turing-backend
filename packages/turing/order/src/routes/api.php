<?php


use Illuminate\Support\Facades\Request;
use Turing\Backend\Http\Requests\BaseFormRequest;
use Turing\Order\Http\Controllers\OrderController;
use Turing\Order\Http\Requests\PostOrderRequest;

Route::post('orders', function(PostOrderRequest $request){
    return app(OrderController::class)->create();
})->middleware('jwt.verify');

Route::get('orders/{orderId}', function(BaseFormRequest $request, int $orderId){
    return app(OrderController::class)->show($orderId);
})->middleware('jwt.verify')->where('orderId', '[0-9]+');


Route::get('orders/inCustomer', 'OrderController@customerOrders')->middleware('jwt.verify');

Route::get('orders/shortDetail/{orderId}', function(BaseFormRequest $request, int $orderId){
    return app(OrderController::class)->showShortDetail($orderId);
})->middleware('jwt.verify')->where('orderId', '[0-9]+');
