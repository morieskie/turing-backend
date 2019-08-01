<?php

namespace Turing\Product\Model;

use Illuminate\Database\Eloquent\Model;
use Turing\Category\Model\Category;
use Turing\Customer\Model\Customer;

class Product extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'product_id';

    public function category(){
        return $this->belongsToMany(Category::class, 'product_category', 'product_id', 'category_id');
    }

    public function reviews(){
        return $this->hasMany(Review::class, 'product_id', 'product_id');
    }

    public function customer()
    {
        return $this->hasManyThrough(Customer::class,Review::class, 'product_id', 'customer_id');
    }
}
