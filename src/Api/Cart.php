<?php

namespace Omatech\LaravelOrders\Api;

use Omatech\LaravelOrders\Exceptions\Cart\CartNotFoundException;

class Cart
{
    /**
     * @var \Omatech\LaravelOrders\Contracts\Cart
     */
    private $cart;

    /**
     * Cart constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->cart = app()->make(\Omatech\LaravelOrders\Contracts\Cart::class);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data = [])
    {
        try {
            $cart = $this->cart->fromArray($data);
            $cart->save();
            $cart = $this->cart::find($cart->getId());
        } catch (\Exception $exception) {
            $cart = false;
        } catch (\TypeError $error) {
            $cart = false;
        }
        return $cart;
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $cart = $this->cart::find($id);

        if (is_null($cart)) {
            return false;
        }

        if (isset($data['id'])) unset($data['id']);

        $cart->fromArray($data);
        $cart->save();

        return true;
    }
}