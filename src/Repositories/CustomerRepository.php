<?php

namespace Omatech\LaravelOrders\Repositories;

use Omatech\LaravelOrders\Models\Customer;

class CustomerRepository extends BaseRepository
{

    /**
     * @return mixed
     */
    public function model()
    {
        return  config('laravel-orders.options.customers.model') ? : Customer::class;
    }
}