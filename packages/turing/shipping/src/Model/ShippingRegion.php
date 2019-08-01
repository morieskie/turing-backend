<?php

namespace Turing\Shipping\Model;

use Illuminate\Database\Eloquent\Model;

class ShippingRegion extends Model
{
    protected $table = 'shipping_region';
    protected $primaryKey = 'shipping_region_id';

    public function shippings()
    {
        return $this->hasMany(Shipping::class, 'shipping_region_id', 'shipping_region_id');
    }
}
