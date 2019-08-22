<?php

namespace Omatech\LaravelOrders\Tests;


use Omatech\LaravelOrders\Api\Order;

class UpdateOrderApiTest extends BaseTestCase
{
    /** @test **/
    public function update_an_order_in_database()
    {
        $data = factory(\Omatech\LaravelOrders\Models\Order::class)->create()->toArray();
        $dataToUpdate = factory(\Omatech\LaravelOrders\Models\Order::class)->make()->toArray();
        $updated = app()->make(Order::class)->update($data['id'], $dataToUpdate);

        $this->assertTrue($updated);

        $this->assertDatabaseHas('orders', [
            'id' => $data['id'],
            'code' => $data['code'],
            'customer_id' => $dataToUpdate['customer_id'],
            'total_price' => $dataToUpdate['total_price'],
        ]);
    }

    /** @test * */
    public function update_a_nonexistent_order_in_database()
    {
        $data = factory(\Omatech\LaravelOrders\Models\Order::class)->create()->toArray();
        $dataToUpdate = factory(\Omatech\LaravelOrders\Models\Order::class)->make()->toArray();
        $updated = app()->make(Order::class)->update(9999, $dataToUpdate);

        $this->assertFalse($updated);

        $this->assertDatabaseHas('orders', [
            'id' => $data['id'],
            'code' => $data['code'],
            'customer_id' => $data['customer_id'],
            'total_price' => $data['total_price'],
        ]);
    }
}