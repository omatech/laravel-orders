<?php

namespace Omatech\LaravelOrders\Repositories;

use Omatech\LaravelOrders\Models\Product;

class ProductRepository extends BaseRepository
{

    /**
     * @return mixed
     */
    public function model()
    {
        return config('laravel-orders.options.products.model') ? : Product::class;
    }
}