<?php

namespace Omatech\LaravelOrders\Tests;

use Omatech\LaravelOrders\Contracts\Cart;

class BasketCheckoutTest extends BaseTestCase
{
    protected $route;

    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->route = route('orders.checkout.basket');
    }

    /** @test */
    public function the_route_status_is_200()
    {
        $cart = app()->make(Cart::class);
        $cart->save();

        $this->withSession(['orders.current_cart.id' => $cart->getId()])
            ->get($this->route)
            ->assertStatus(200)
            ->assertViewIs('laravel-orders::pages.checkout.basket')
            ->assertViewHas('cart');
    }

    /** @test **/
    public function show_without_cart()
    {

        $this->get($this->route)
            ->assertStatus(500);
    }

}