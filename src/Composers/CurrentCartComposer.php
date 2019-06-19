<?php

namespace Omatech\LaravelOrders\Composers;

use Illuminate\View\View;
use Omatech\LaravelOrders\Contracts\Cart;

class CurrentCartComposer
{

    /**
     * @var Cart
     */
    private $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function compose(View $views)
    {
        $currentCartId = session('orders.current_cart.id');
        $this->cart = $currentCartId ? $this->cart::find($currentCartId) : $this->cart;

        $views->with([
            'currentCart' => $this->cart
        ]);
    }

}