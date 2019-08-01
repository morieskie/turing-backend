<?php

namespace Turing\Cart\Model;

use Illuminate\Database\Eloquent\Model;
use Turing\Product\Model\Product;

class Cart extends Model
{
    protected $table = 'shopping_cart';
    protected $primaryKey = 'item_id';
    protected $fillable = ['item_id', 'cart_id', 'name', 'attributes', 'product_id', 'price', 'quantity', 'subtotal', 'added_on','buy_now', 'added_on'];
    public $timestamps = false;
    public $dates = ['added_on'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
