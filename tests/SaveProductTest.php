<?php

namespace Omatech\LaravelOrders\Tests;


use Omatech\LaravelOrders\Objects\Product;

class SaveProductTest extends BaseTestCase
{
    /** @test * */
    public function saved_in_database()
    {
        $product = app()->make(Product::class);

        $data = [];
        $product->load($data);
        $product->save();

        $this->assertFalse(empty($product->getId()));
        $this->assertDatabaseHas('products', ['id' => $product->getId()] + $data);

        $data = ['id' => 1];
        $product->load($data);
        $product->save();

        $this->assertFalse(empty($product->getId()));
        $this->assertDatabaseHas('products', ['id' => $product->getId()] + $data);
    }
}