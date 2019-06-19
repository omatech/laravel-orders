<?php

namespace Omatech\LaravelOrders\Tests;


use Omatech\LaravelOrders\Contracts\Product;
use Omatech\LaravelOrders\Contracts\Cart;

class SaveCartTest extends BaseTestCase
{
    /** @test * */
    public function saved_in_database()
    {
        $cart = app()->make(Cart::class);

        $data = [];
        $cart->load($data);
        $cart->save();

        $this->assertFalse(empty($cart->getId()));
        $this->assertDatabaseHas('carts', ['id' => $cart->getId()] + $data);

        $data = ['id' => 1];
        $cart->load($data);
        $cart->save();

        $this->assertFalse(empty($cart->getId()));
        $this->assertDatabaseHas('carts', ['id' => $cart->getId()] + $data);
    }

    /** @test **/
    public function saved_with_cart_lines()
    {
        $cart = app()->make(Cart::class);

        $data = [];
        $cart->load($data);

        $product = app()->make(Product::class);
        $product->save();
        $product->setRequestedQuantity(4);

        $cart->push($product);

        $cart->save();

        $this->assertDatabaseHas('carts', [
            'id' => $cart->getId()
        ]);

        $this->assertDatabaseHas('cart_lines', [
            'cart_id' => $cart->getId(),
            'product_id' => $product->getId(),
            'quantity' => 4
        ]);
    }

    /** @test **/
    public function saved_multiple_cart_lines()
    {
        $cart = app()->make(Cart::class);

        $data = [];
        $cart->load($data);

        $product = app()->make(Product::class);
        $product->save();
        $product->setRequestedQuantity(4);

        $cart->push($product);

        $product2 = app()->make(Product::class);
        $product2->save();
        $product2->setRequestedQuantity(5);

        $cart->push($product2);

        $cart->save();

        $this->assertDatabaseHas('carts', [
            'id' => $cart->getId()
        ]);

        $this->assertDatabaseHas('cart_lines', [
            'cart_id' => $cart->getId(),
            'product_id' => $product->getId(),
            'quantity' => 4
        ]);

        $this->assertDatabaseHas('cart_lines', [
            'cart_id' => $cart->getId(),
            'product_id' => $product2->getId(),
            'quantity' => 5
        ]);
    }

    /** @test **/
    public function saved_with_cart_lines_if_cart_exists()
    {
        $fakeCart = app()->make(Cart::class);
        $fakeCart->save();

        $cart = app()->make(Cart::class);
        $data = ['id' => $fakeCart->getId()];
        $cart->load($data);

        $product = app()->make(Product::class);
        $product->save();

        $product->setRequestedQuantity(1);

        $cart->push($product);

        $cart->save();

        $this->assertDatabaseHas('carts', [
            'id' => $cart->getId()
        ]);

        $this->assertDatabaseHas('cart_lines', [
            'cart_id' => $cart->getId(),
            'product_id' => $product->getId()
        ]);
    }
}