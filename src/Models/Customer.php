<?php

namespace Omatech\LaravelOrders\Models;


use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'birthday',
        'phone_number',
        'gender',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (config('laravel-orders.options.users.enabled') === true) {
            $this->fillable[] = 'user_id';
        }
    }

    public function deliveryAddresses()
    {
        return $this->hasMany(DeliveryAddress::class);
    }
}