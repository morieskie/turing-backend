<?php

// Generate the unique cart ID
use Illuminate\Support\Facades\Request;
use Turing\Backend\Http\Requests\BaseFormRequest;
use Turing\Cart\Http\Requests\PostAddToCartRequest;
use Turing\Cart\Http\Requests\PutUpdateCartItemRequest;
use Turing\Cart\Http\Controllers\CartController;

Route::get('/shoppingcart/generateUniqueId', 'CartController@generateId');

// Add product to cart
Route::post('/shoppingcart/add', function(PostAddToCartRequest $request){
    return app(CartController::class)->create();
});

// Get list of products in cart
Route::get('/shoppingcart/{cartId}', function(BaseFormRequest $request, string $cartId){
    return app(CartController::class)->showCartItems($cartId);
});

// Update item on cart
Route::put('/shoppingcart/update/{itemId}', function(PutUpdateCartItemRequest $request, int $itemId){
    return app(CartController::class)->update($itemId);
});

// Empty cart
Route::delete('/shoppingcart/empty/{cartId}', function(BaseFormRequest $request, string $cartId){
    return app(CartController::class)->deleteCart($cartId);
});

// Move a product to cart
Route::get('/shoppingcart/moveToCart/{itemId}', function(BaseFormRequest $request, string $itemId){
    return app(CartController::class)->moveToCart($itemId);
});

// Return total amount from cart
Route::get('/shoppingcart/totalAmount/{cartId}', function(BaseFormRequest $request, string $cartId){
    return app(CartController::class)->cartTotal($cartId);
});

// Save a product for later
Route::get('/shoppingcart/saveForLater/{itemId}', function(BaseFormRequest $request, string $itemId){
    return app(CartController::class)->saveForLater($itemId);
});

// get products for later
Route::get('/shoppingcart/getSaved/{cartId}', function(BaseFormRequest $request, string $cartId){
    return app(CartController::class)->getSaved($cartId);
});

// Remove item from cart
Route::delete('/shoppingcart/removeProduct/{itemId}', function(BaseFormRequest $request, int $itemId){
    return app(CartController::class)->delete($itemId);
});
