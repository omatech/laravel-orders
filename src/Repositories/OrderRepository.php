<?php

namespace Omatech\LaravelOrders\Repositories;

use Omatech\LaravelOrders\Models\Order;

class OrderRepository extends BaseRepository
{

    /**
     * @return mixed
     */
    public function model()
    {
        return config('laravel-orders.options.orders.model') ? :  Order::class;
    }
}