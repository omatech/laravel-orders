<?php

namespace Omatech\LaravelOrders\Repositories\Cart;

use Omatech\LaravelOrders\Contracts\Cart;
use Omatech\LaravelOrders\Models\CartLine;
use Omatech\LaravelOrders\Repositories\CartRepository;

class FindCart extends CartRepository
{
    /**
     * @param Cart $cart
     * @return mixed
     */
    public function make(Cart $cart)
    {
        $eCart = $this->model->find($cart->getId())->toArray();

        return $cart->load($eCart);
    }
}