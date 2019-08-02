<?php

namespace Turing\Order\Model;

use Illuminate\Database\Eloquent\Model;
use Turing\Customer\Model\Customer;
use Turing\Shipping\Model\Shipping;
use Turing\Tax\Model\Tax;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    public $timestamps = false;
    public $dates = ['created_on', 'shipped_on'];
    public $fillable = ['order_id', 'total_amount', 'created_on', 'shipped_on', 'status', 'comments',
        'customer_id', 'auth_code', 'reference', 'shipping_id', 'tax_id'];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'order_id');
    }

    public function items()
    {
        return $this->orderDetails();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class, 'shipping_id', 'shipping_id');
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id', 'tax_id');
    }
}
