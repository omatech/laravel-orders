<?php

namespace Omatech\LaravelOrders\Tests;

use Omatech\LaravelOrders\Contracts\Order;

class OrderObjectTest extends BaseTestCase
{
    /** @test * */
    public function new_instance_contains_code()
    {
        $order = app()->make(Order::class);

        $this->assertNotNull($order->getCode());
        $this->assertFalse(is_object($order->getCode()));
    }
}