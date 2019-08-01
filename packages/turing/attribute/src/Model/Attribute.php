<?php

namespace Turing\Attribute\Model;

use Illuminate\Database\Eloquent\Model;
use Turing\Product\Model\Product;
use Turing\Product\Model\ProductAttribute;

class Attribute extends Model
{
    protected $table = 'attribute';
    protected $primaryKey = 'attribute_id';

    public function values(){
        return $this->hasMany(AttributeValue::class,'attribute_id','attribute_id');
    }

    public function products(){
        return $this->belongsToMany(Product::class,'product_attribute','attribute_value_id','product_id')
           ;
    }
}
