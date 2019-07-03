<?php

namespace Omatech\LaravelOrders\Tests;

use Omatech\LaravelOrders\Contracts\Order;
use Omatech\LaravelOrders\Contracts\OrderLine;
use Omatech\LaravelOrders\Models\Customer as CustomerModel;
use Omatech\LaravelOrders\Models\Order as OrderModel;

class SaveOrderTest extends BaseTestCase
{
    /** @test * */
    public function saved_in_database()
    {
        $order = app()->make(Order::class);

        $data = [
            'customer_id' => factory(CustomerModel::class)->create()->id
        ];
        $order->fromArray($data);
        $order->save();

        $this->assertFalse(empty($order->getId()));
        $this->assertDatabaseHas('orders', ['id' => $order->getId()] + $data);

        $data = ['id' => 1];
        $order->fromArray($data);
        $order->save();

        $this->assertFalse(empty($order->getId()));
        $this->assertDatabaseHas('orders', ['id' => $order->getId()] + $data);
    }

    /** @test * */
    public function saved_with_order_lines()
    {
        $order = app()->make(Order::class);

        $data = [
            'customer_id' => factory(CustomerModel::class)->create()->id
        ];
        $order->fromArray($data);

        $quantity = 55;
        $orderLine = app()->make(OrderLine::class);
        $orderLine->setQuantity($quantity);

        $order->pushLine($orderLine);

        $order->save();

        $this->assertDatabaseHas('orders', [
            'id' => $order->getId()
        ]);

        $this->assertDatabaseHas('order_lines', [
            'order_id' => $order->getId(),
            'quantity' => $quantity
        ]);
    }

    /** @test * */
    public function saved_multiple_order_lines()
    {
        $order = app()->make(Order::class);

        $data = [
            'customer_id' => factory(CustomerModel::class)->create()->id
        ];
        $order->fromArray($data);

        $quantity = 4;
        $orderLine = app()->make(OrderLine::class);
        $orderLine->setQuantity($quantity);

        $order->pushLine($orderLine);

        $quantity2 = 5;
        $orderLine2 = app()->make(OrderLine::class);
        $orderLine2->setQuantity($quantity2);

        $order->pushLine($orderLine2);

        $order->save();

        $this->assertDatabaseHas('orders', [
            'id' => $order->getId()
        ]);

        $this->assertDatabaseHas('order_lines', [
            'order_id' => $order->getId(),
            'quantity' => $quantity
        ]);

        $this->assertDatabaseHas('order_lines', [
            'order_id' => $order->getId(),
            'quantity' => $quantity2
        ]);
    }

    /** @test * */
    public function saved_with_order_lines_if_order_exists()
    {
        $fakeOrder = app()->make(Order::class);
        $data = [
            'customer_id' => factory(CustomerModel::class)->create()->id
        ];
        $fakeOrder->fromArray($data);
        $fakeOrder->save();

        $order = app()->make(Order::class);
        $data = [
            'id' => $fakeOrder->getId(),
            'customer_id' => factory(CustomerModel::class)->create()->id
        ];
        $order->fromArray($data);

        $quantity = 6;
        $orderLine = app()->make(OrderLine::class);
        $orderLine->setQuantity($quantity);

        $order->pushLine($orderLine);

        $order->save();

        $this->assertDatabaseHas('orders', [
            'id' => $order->getId()
        ]);

        $this->assertDatabaseHas('order_lines', [
            'order_id' => $order->getId(),
            'quantity' => $quantity
        ]);
    }

    public function throw_error_if_order_is_saved_without_customer_id()
    {
        //TODO
    }

    /** @test * */
    public function check_order_code_is_saved()
    {
        $fakeOrder = app()->make(Order::class);
        $code = $fakeOrder->getCode();

        $this->assertNotNull($code);

        $data = [
            'customer_id' => factory(CustomerModel::class)->create()->id
        ];
        $fakeOrder->fromArray($data);
        $fakeOrder->save();

        $this->assertDatabaseHas('orders', [
            'code' => $code
        ]);
    }

    /** @test * */
    public function check_delivery_address_and_billing_data_are_saved()
    {
        $data = factory(OrderModel::class)->make()->toArray();

        $fakeOrder = app()->make(Order::class);
        $fakeOrder->fromArray($data);
        $fakeOrder->save();

        $data['code'] = $fakeOrder->getCode();
        $this->assertDatabaseHas('orders', $data);
    }
}