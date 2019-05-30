<?php

namespace Omatech\LaravelOrders\Tests;

use Omatech\LaravelOrders\Repositories\Order\CreateOrder;

class CreateOrderTest extends BaseTestCase
{
    /** @test **/
    public function saved_in_database()
    {
        $createOrder = new CreateOrder();

        $data = [];
        $order = $createOrder->make($data);

        $this->assertFalse(empty($order->id));
        $this->assertDatabaseHas('orders', ['id' => $order->id] + $data);
    }

    //TODO test invoke method
}