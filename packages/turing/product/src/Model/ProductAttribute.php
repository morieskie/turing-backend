<?php

namespace Turing\Product\Model;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $table = 'product_attribute';
    protected $primaryKey = ['product_id','attribute_value_id'];
}
