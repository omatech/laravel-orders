<?php

namespace Omatech\LaravelOrders\Tests;

use Omatech\LaravelOrders\Contracts\FindAllCarts;
use Omatech\LaravelOrders\Models\Cart;

class FindAllCartsTest extends BaseTestCase
{
    /** @test * */
    public function check_if_we_can_find_all_carts()
    {
        $carts = factory(Cart::class, 10)->create()->toArray();

        $findCarts = app(FindAllCarts::class)->make();

        $this->assertTrue(is_array($findCarts));
        $this->assertEquals(10, count($findCarts));
        $firstNames = array_column($carts, 'id');

        foreach ($findCarts as $cart) {
            $this->assertTrue(array_search($cart->getId(), $firstNames) !== false);
        }
    }

    /** @test * */
    public function call_find_all_statically_from_cart_object()
    {
        $carts = factory(Cart::class, 10)->create()->toArray();

        $findCarts = app(\Omatech\LaravelOrders\Contracts\Cart::class)::findAll();

        $this->assertTrue(is_array($findCarts));
        $this->assertEquals(10, count($findCarts));
        $firstNames = array_column($carts, 'id');

        foreach ($findCarts as $cart) {
            $this->assertTrue(array_search($cart->getId(), $firstNames) !== false);
        }
    }

}