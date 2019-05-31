<?php

namespace Omatech\LaravelOrders\Controllers;

use Omatech\LaravelOrders\Contracts\Cart;
use Omatech\LaravelOrders\Requests\AddProductToCartRequest;

class CartController
{
    protected $cart;
    protected $currentCartId;

    /**
     * CheckoutController constructor.
     * @param Cart $cart
     */
    public function __construct(Cart $cart)
    {
        $this->currentCartId = session('orders.current_cart.id');

        $this->cart = $this->currentCartId ? $cart::find($this->currentCartId) : $cart;
    }

    /**
     * @param AddProductToCartRequest $request
     */
    public function addProduct(AddProductToCartRequest $request)
    {
        $product = $request->get('product');

        $this->cart->push($product);

        $this->cart->save();

        if (is_null($this->currentCartId)) {
            session(['orders.current_cart.id' => $this->cart->getId()]);
        }
    }
}