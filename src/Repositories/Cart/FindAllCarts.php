<?php

namespace Omatech\LaravelOrders\Repositories\Cart;

use Omatech\LaravelOrders\Contracts\Cart;
use Omatech\LaravelOrders\Contracts\FindAllCarts as FindAllCartsInterface;
use Omatech\LaravelOrders\Repositories\CartRepository;

class FindAllCarts extends CartRepository implements FindAllCartsInterface
{
    /**
     * @var Cart
     */
    private $cart;

    /**
     * FindAllCarts constructor.
     * @param Cart $cart
     * @throws \Exception
     */
    public function __construct(Cart $cart)
    {
        parent::__construct();
        $this->cart = $cart;
    }

    /**
     * @return array
     */
    public function make(): array
    {
        $return = [];
        $all = $this->model->all();

        if (empty($all)) {
            return $return;
        }

        foreach ($all as $value) {
            $cart = $this->cart;
            array_push($return, $cart->fromArray($value->toArray()));
        }

        return $return;
    }
}