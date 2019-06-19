<?php

namespace Omatech\LaravelOrders\Tests;


use Omatech\LaravelOrders\Contracts\Cart;
use Omatech\LaravelOrders\Contracts\Product;
use Omatech\LaravelOrders\Repositories\Cart\FindCart;

class AddProductCartTest extends BaseTestCase
{

    /** @test * */
    public function product_to_nonexisting_cart()
    {
        $product = app()->make(Product::class);
        $product->setRequestedQuantity(1);
        $product->save();

        $cart = app()->make(Cart::class);
        $cart->push($product);
        $cart->save();

        $currentCartId = $cart->getId();

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

        $cart->push($product);
        $cart->save();

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

        $cart->push($product);
        $cart->save();

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

        $cart->push($product);
        $cart->save();

        $this->assertDatabaseHas('cart_lines', [
            'product_id' => $product->getId(),
            'cart_id' => $cart->getId(),
            'quantity' => 1
        ]);

        $product->setRequestedQuantity(3);

        $cart->push($product);
        $cart->save();

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

        $cart->push($product);
        $cart->save();

        $this->assertDatabaseHas('cart_lines', [
            'product_id' => $product->getId(),
            'cart_id' => $cart->getId(),
            'quantity' => 1
        ]);

        $product->setRequestedQuantity(-1);

        $cart->push($product);
        $cart->save();

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

        $cart->push($product);
        $cart->save();

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

        $cart->push($product);
        $cart->save();

        $this->assertDatabaseMissing('cart_lines', [
            'product_id' => $product->getId(),
            'cart_id' => $cart->getId()
        ]);

        $product->setRequestedQuantity(1);

        $cart->push($product);
        $cart->save();

        $this->assertDatabaseHas('cart_lines', [
            'product_id' => $product->getId(),
            'cart_id' => $cart->getId(),
            'quantity' => 1
        ]);

        $product->setRequestedQuantity(-2);

        $cart->push($product);
        $cart->save();

        $this->assertDatabaseMissing('cart_lines', [
            'product_id' => $product->getId(),
            'cart_id' => $cart->getId(),
        ]);
    }
}