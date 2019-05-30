<?php

namespace Omatech\LaravelOrders\Controllers;

use Omatech\LaravelOrders\Contracts\Cart;
use Omatech\LaravelOrders\Repositories\Cart\FindCart;
use Omatech\LaravelOrders\Requests\AddProductToCartRequest;

class CartController
{
    protected $cart;
    protected $currentCartId;

    /**
     * CheckoutController constructor.
     * @param Cart $cart
     * @param FindCart $findCart
     */
    public function __construct(Cart $cart, FindCart $findCart)
    {
        $this->currentCartId = session('orders.current_cart.id');

        if ($this->currentCartId) {
            $cart->setId($this->currentCartId);
            $this->cart = $findCart->make($cart);
        } else {
            $this->cart = $cart;
        }
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