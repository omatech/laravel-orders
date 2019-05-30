<?php

namespace Omatech\LaravelOrders\Tests;

use Omatech\LaravelOrders\Contracts\Cart;

class SummaryCheckoutTest extends BaseTestCase
{
    /** @test */
    public function the_route_status_is_200()
    {
        $cart = app()->make(Cart::class);
        $cart->save();

        $this->withSession(['orders.current_cart.id' => $cart->getId()])->get(route('orders.checkout.summary'))
            ->assertStatus(200)
            ->assertViewIs('laravel-orders::pages.checkout.summary');
    }
}