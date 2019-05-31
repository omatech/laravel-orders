<?php

namespace Omatech\LaravelOrders\Tests;


use Omatech\LaravelOrders\Contracts\Cart;

class FindCartTest extends BaseTestCase
{

    /** @test **/
    public function found_existing_cart()
    {
        $cart = app()->make(Cart::class);
        $cart->save();

        $findCart = app()->make(Cart::class)::find($cart->getId());

        $this->assertEquals($findCart->getId(), $cart->getId());
    }
    
}