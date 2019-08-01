<?php

namespace Turing\Shipping\Model;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $table = 'shipping';
    protected $primaryKey = 'shipping_id';

    public function regions(){
        return $this->belongsTo(ShippingRegion::class,'shipping_region_id');
    }
}
