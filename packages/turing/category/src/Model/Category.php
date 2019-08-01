<?php

namespace Turing\Category\Model;

use Illuminate\Database\Eloquent\Model;
use Turing\Department\Model\Department;
use Turing\Product\Model\Product;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'category_id';

    public function products(){
        return $this->belongsToMany(Product::class, 'product_category', 'category_id', 'product_id');
    }

    public function departments(){
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }
}
