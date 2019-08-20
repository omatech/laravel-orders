<?php

namespace Omatech\LaravelOrders\Tests;

use Omatech\LaravelOrders\Api\Order;

class CreateOrderApiTest extends BaseTestCase
{
    /** @test * */
    public function save_a_new_order_in_database()
    {
        $data = factory(\Omatech\LaravelOrders\Models\Order::class)->make()->toArray();
        $order = app()->make(Order::class)->create($data);

        $this->assertFalse(empty($order->getId()));

        $this->assertTrue(is_a($order, \Omatech\LaravelOrders\Objects\Order::class));

        $this->assertEquals($data['total_price'], $order->getTotalPrice());

        $this->assertDatabaseHas('orders', [
            'id' => $order->getId(),
            'code' => $order->getCode(),
            'customer_id' => $data['customer_id'],
            'total_price' => $data['total_price'],
        ]);

        $this->assertDatabaseMissing('orders', [
            'id' => $order->getId(),
            'code' => $data['code'],
        ]);
    }

    /** @test **/
    public function save_empty_if_data_is_empty()
    {
        $order = app()->make(Order::class)->create();

        $this->assertTrue(!empty($order->getCode()));

        $this->assertDatabaseHas('orders', [
            'id' => 1,
        ]);
    }
}