<?php

namespace Omatech\LaravelOrders\Tests;


use Omatech\LaravelOrders\Contracts\Product;
use Omatech\LaravelOrders\Models\Order;
use Omatech\LaravelOrders\Models\OrderLine;

class OrderLineObjectTest extends BaseTestCase
{
    /** @test **/
    public function get_product_from_order_line()
    {
        $order = factory(Order::class)->create();
        factory(OrderLine::class)->create([
            'order_id' => $order->id
        ]);

        $orderObject = app()->make(\Omatech\LaravelOrders\Objects\Order::class)->find($order->id);

        $product = $orderObject->getLines()[0]->getProduct();

        $this->assertTrue(is_a($product, Product::class));
    }
}