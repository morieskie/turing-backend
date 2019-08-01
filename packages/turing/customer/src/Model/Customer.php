<?php

namespace Turing\Customer\Model;

use App\User;
use Turing\Order\Model\Order;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Customer extends User implements JWTSubject
{
    protected $table = 'customer';
    protected $primaryKey = 'customer_id';
    protected $fillable = ['name', 'email', 'password', 'address_1', 'address_2', 'city', 'region', 'postal_code',
        'shipping_region_id', 'credit_card', 'day_phone', 'eve_phone', 'mob_phone', 'country'];
    protected $hidden = ['password'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get the relationships for the entity.
     *
     * @return array
     */
    public function getQueueableRelations()
    {
        // TODO: Implement getQueueableRelations() method.
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'customer_id');
    }
}
