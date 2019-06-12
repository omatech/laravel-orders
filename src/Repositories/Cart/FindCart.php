<?php

namespace Omatech\LaravelOrders\Repositories\Cart;

use Omatech\LaravelOrders\Contracts\Cart;
use Omatech\LaravelOrders\Repositories\CartRepository;

class FindCart extends CartRepository implements \Omatech\LaravelOrders\Contracts\FindCart
{
    private $cart;

    /**
     * FindCart constructor.
     * @param Cart $cart
     * @throws \Exception
     */
    public function __construct(Cart $cart)
    {
        parent::__construct();
        $this->cart = $cart;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function make(int $id): ?Cart
    {
        $cart = optional($this->model->find($id))->toArray();

        return is_array($cart) ? $this->cart->load($cart) : null;
    }
}