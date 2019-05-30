<?php

namespace Omatech\LaravelOrders\Tests;


use Omatech\LaravelOrders\Contracts\Cart;
use Omatech\LaravelOrders\Contracts\Product;
use Omatech\LaravelOrders\Repositories\Cart\FindCart;

class AddProductCartTest extends BaseTestCase
{
    protected $route;

    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->route = route('orders.cart.addProduct');
    }

    /** @test */
    public function the_route_status_is_200()
    {
        $product = app()->make(Product::class);
        $product->setRequestedQuantity(1);
        $product->save();

        $this->post($this->route, [
            'product' => $product
        ])->assertStatus(200);
    }

    /** @test * */
    public function product_to_nonexisting_cart()
    {
        $product = app()->make(Product::class);
        $product->setRequestedQuantity(1);
        $product->save();

        $this->assertFalse(session()->exists('orders.current_cart.id'));

        $this->post($this->route, [
            'product' => $product
        ]);
        $this->assertTrue(session()->exists('orders.current_cart.id'));

        $currentCartId = session('orders.current_cart.id');

        $this->assertDatabaseHas('carts', [
            'id' => $currentCartId
        ]);

        $this->assertDatabaseHas('cart_lines', [
            'product_id' => $product->getId(),
            'cart_id' => $currentCartId,
            'quantity' => 1
        ]);
    }

    /** @test * */
    public function existing_new_product_to_existing_cart()
    {
        $product = app()->make(Product::class);
        $product->setRequestedQuantity(1);
        $product->save();

        $cart = app()->make(Cart::class);
        $cart->save();

        $data = [
            'product' => $product
        ];

        $this->withSession(['orders.current_cart.id' => $cart->getId()])
            ->post($this->route, $data);

        $this->assertDatabaseHas('cart_lines', [
            'product_id' => $product->getId(),
            'cart_id' => $cart->getId()
        ]);
    }

    /** @test * */
    public function nonexisting_product_to_existing_cart()
    {
        $product = app()->make(Product::class);
        $product->setRequestedQuantity(1);
        $product->setId(9875);

        $cart = app()->make(Cart::class);
        $cart->save();

        $this->withSession(['orders.current_cart.id' => $cart->getId()])
            ->post($this->route, [
                'product' => $product
            ]);

        $this->assertDatabaseMissing('cart_lines', [
            'product_id' => $product->getId(),
            'cart_id' => $cart->getId(),
        ]);
    }

    /** @test * */
    public function repeated_product_to_existing_cart()
    {
        $product = app()->make(Product::class);
        $product->setRequestedQuantity(1);
        $product->save();

        $cart = app()->make(Cart::class);
        $cart->save();

        $this->withSession(['orders.current_cart.id' => $cart->getId()])
            ->post($this->route, [
                'product' => $product
            ]);

        $this->assertDatabaseHas('cart_lines', [
            'product_id' => $product->getId(),
            'cart_id' => $cart->getId(),
            'quantity' => 1
        ]);

        $product->setRequestedQuantity(3);

        $this->withSession(['orders.current_cart.id' => $cart->getId()])
            ->post($this->route, [
                'product' => $product
            ]);

        $this->assertDatabaseMissing('cart_lines', [
            'product_id' => $product->getId(),
            'cart_id' => $cart->getId(),
            'quantity' => 1
        ]);

        $this->assertDatabaseHas('cart_lines', [
            'product_id' => $product->getId(),
            'cart_id' => $cart->getId(),
            'quantity' => 4
        ]);
    }

    /** @test * */
    public function remove_product_to_existing_cart()
    {
        $product = app()->make(Product::class);
        $product->setRequestedQuantity(1);
        $product->save();

        $cart = app()->make(Cart::class);
        $cart->save();

        $this->withSession(['orders.current_cart.id' => $cart->getId()])
            ->post($this->route, [
                'product' => $product
            ]);

        $this->assertDatabaseHas('cart_lines', [
            'product_id' => $product->getId(),
            'cart_id' => $cart->getId(),
            'quantity' => 1
        ]);

        $product->setRequestedQuantity(-1);

        $this->withSession(['orders.current_cart.id' => $cart->getId()])
            ->post($this->route, [
                'product' => $product
            ]);

        $this->assertDatabaseMissing('cart_lines', [
            'product_id' => $product->getId(),
            'cart_id' => $cart->getId(),
        ]);
    }

    /** @test **/
    public function can_not_add_product_with_zero_quantity()
    {
        $product = app()->make(Product::class);
        $product->setRequestedQuantity(0);
        $product->save();

        $cart = app()->make(Cart::class);
        $cart->save();

        $this->withSession(['orders.current_cart.id' => $cart->getId()])
            ->post($this->route, [
                'product' => $product
            ]);

        $this->assertDatabaseMissing('cart_lines', [
            'product_id' => $product->getId(),
            'cart_id' => $cart->getId()
        ]);
    }

    /** @test **/
    public function can_not_add_product_with_global_negative_quantity()
    {
        $product = app()->make(Product::class);
        $product->setRequestedQuantity(-1);
        $product->save();

        $cart = app()->make(Cart::class);
        $cart->save();

        $this->withSession(['orders.current_cart.id' => $cart->getId()])
            ->post($this->route, [
                'product' => $product
            ]);

        $this->assertDatabaseMissing('cart_lines', [
            'product_id' => $product->getId(),
            'cart_id' => $cart->getId()
        ]);

        $product->setRequestedQuantity(1);

        $this->withSession(['orders.current_cart.id' => $cart->getId()])
            ->post($this->route, [
                'product' => $product
            ]);

        $this->assertDatabaseHas('cart_lines', [
            'product_id' => $product->getId(),
            'cart_id' => $cart->getId(),
            'quantity' => 1
        ]);

        $product->setRequestedQuantity(-2);

        $this->withSession(['orders.current_cart.id' => $cart->getId()])
            ->post($this->route, [
                'product' => $product
            ]);

        $this->assertDatabaseMissing('cart_lines', [
            'product_id' => $product->getId(),
            'cart_id' => $cart->getId(),
        ]);
    }
}