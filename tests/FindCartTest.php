<?php

namespace Omatech\LaravelOrders\Tests;

use Omatech\LaravelOrders\Contracts\Cart;
use Omatech\LaravelOrders\Contracts\CartLine;
use Omatech\LaravelOrders\Contracts\Product;

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

    /** @test **/
    public function found_nonexisting_cart_returns_null()
    {
        $findCart = app()->make(Cart::class)::find(999);
        $this->assertEquals($findCart, null);
    }

    /** @test **/
    public function found_cart_with_cart_lines()
    {
        $product = app()->make(Product::class);
        $product->setRequestedQuantity(1);
        $product->save();

        $cart = app()->make(Cart::class);
        $cart->push($product);
        $cart->save();

        $findCart = app()->make(Cart::class)::find($cart->getId());

        $findProducts = $findCart->getCartLines();

        $this->assertFalse(is_null($findProducts));
        $this->assertTrue(is_a($findProducts[0], CartLine::class));
        $this->assertEquals($product->toCartLine(), $findProducts[0]);
    }
    
}