<?php

use Turing\Payment\Http\Controllers\StripeController;
use Turing\Payment\Http\Requests\PostStripeChargeRequest;
use Turing\Payment\Http\Requests\PostStripeTokenRequest;
use Turing\Payment\Http\Requests\PostStripeWebhookRequest;

Route::post('/stripe/charge', function (PostStripeChargeRequest $request){
    return app(StripeController::class)->process();
});

Route::post('/stripe/token', function (PostStripeTokenRequest $request){
    return app(StripeController::class)->getToken();
});

Route::post('/stripe/webhooks', function (PostStripeWebhookRequest $request){
    return app(StripeController::class)->handle();
});
