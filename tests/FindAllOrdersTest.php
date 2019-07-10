<?php

namespace Omatech\LaravelOrders\Tests;


use Omatech\LaravelOrders\Contracts\FindAllOrders;
use Omatech\LaravelOrders\Models\Order;

class FindAllOrdersTest extends BaseTestCase
{
    /** @test * */
    public function check_if_we_can_find_all_orders()
    {
        $orders = factory(Order::class, 10)->create()->toArray();

        $findOrders = app(FindAllOrders::class)->make();

        $this->assertTrue(is_array($findOrders));
        $this->assertEquals(10, count($findOrders));
        $codes = array_column($orders, 'code');

        foreach ($findOrders as $order) {
            $this->assertTrue(array_search($order->getCode(), $codes) !== false);
        }
    }

    /** @test * */
    public function call_find_all_statically_from_order_object()
    {
        $orders = factory(Order::class, 10)->create()->toArray();

        $findOrders = app(\Omatech\LaravelOrders\Contracts\Order::class)::findAll();

        $this->assertTrue(is_array($findOrders));
        $this->assertEquals(10, count($findOrders));
        $codes = array_column($orders, 'code');

        foreach ($findOrders as $order) {
            $this->assertTrue(array_search($order->getCode(), $codes) !== false);
        }
    }

}