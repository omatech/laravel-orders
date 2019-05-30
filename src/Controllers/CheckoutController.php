<?php

namespace Omatech\LaravelOrders\Controllers;

use Illuminate\Routing\Controller;
use Omatech\LaravelOrders\Contracts\Cart;
use Omatech\LaravelOrders\Middleware\ThrowErrorIfSessionCartIdNotExists;
use Omatech\LaravelOrders\Repositories\Cart\FindCart;

class CheckoutController extends Controller
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
        $this->middleware([ThrowErrorIfSessionCartIdNotExists::class]);

        $this->currentCartId = session('orders.current_cart.id');
        $cart->setId($this->currentCartId);
        $this->cart = $findCart->make($cart);//TODO el find no retorna les cart_lines

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function basket()
    {
        return view('laravel-orders::pages.checkout.basket', [
            'cart' => $this->cart
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delivery()
    {
        //TODO
        return view('laravel-orders::pages.checkout.delivery');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function payment()
    {
        //TODO
        return view('laravel-orders::pages.checkout.payment');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function summary()
    {
        //TODO
        return view('laravel-orders::pages.checkout.summary');
    }
}