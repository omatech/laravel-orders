<?php

namespace Omatech\LaravelOrders\Repositories;

use Omatech\LaravelOrders\Models\Cart;

class CartRepository extends BaseRepository
{

    /**
     * @return mixed
     */
    public function model()
    {
        return Cart::class;
    }
}