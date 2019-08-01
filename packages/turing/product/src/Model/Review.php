<?php

namespace Turing\Product\Model;

use Illuminate\Database\Eloquent\Model;
use Turing\Customer\Model\Customer;

class Review extends Model
{
    protected $table = 'review';
    protected $primaryKey = 'review_id';
    protected $fillable = ['product_id','review','rating', 'customer_id','created_on'];
    public $timestamps = false;
    public $dates = ['created_on'];

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
}
