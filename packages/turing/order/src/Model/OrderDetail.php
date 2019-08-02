<?php

namespace Turing\Order\Model;

use Illuminate\Database\Eloquent\Model;
use Turing\Product\Model\Product;

/**
 * Class OrderDetail
 * @package Turing\Order\Model
 */
class OrderDetail extends Model
{
    protected $table = 'order_detail';
    protected $primaryKey = 'item_id';
    public $timestamps = false;
    public $fillable = ['item_id','order_id','product_id','attributes','product_name','quantity','unit_cost'];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id','order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','product_id');
    }
}
