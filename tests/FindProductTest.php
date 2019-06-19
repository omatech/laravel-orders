<?php

namespace Omatech\LaravelOrders\Tests;

use Omatech\LaravelOrders\Contracts\Product;

class FindProductTest extends BaseTestCase
{

    /** @test * */
    public function found_existing_product()
    {
        $product = app()->make(Product::class);
        $product->save();

        $findProduct = app()->make(Product::class)::find($product->getId());

        $this->assertEquals($findProduct->getId(), $product->getId());
    }

    /** @test * */
    public function found_nonexistent_product_returns_null()
    {
        $findProduct = app()->make(Product::class)::find(999);
        $this->assertEquals($findProduct, null);
    }

}