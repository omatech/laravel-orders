<?php

namespace Omatech\LaravelOrders\Api;

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
        }catch (\Exception $exception){
            $cart = false;
        }catch (\TypeError $error){
            $cart = false;
        }
        return $cart;
    }
}