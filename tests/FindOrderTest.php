<?php

namespace Omatech\LaravelOrders\Tests;

use Omatech\LaravelOrders\Contracts\BillingData;
use Omatech\LaravelOrders\Contracts\DeliveryAddress;
use Omatech\LaravelOrders\Contracts\OrderLine as OrderLineInterface;
use Omatech\LaravelOrders\Models\Order as OrderModel;
use Omatech\LaravelOrders\Models\OrderLine as OrderLineModel;
use Omatech\LaravelOrders\Contracts\Order as OrderInterface;

class FindOrderTest extends BaseTestCase
{

    /** @test * */
    public function found_existing_order()
    {
        $order = factory(OrderModel::class)->create();
        $orderId = $order->id;

        $findOrder = app()->make(OrderInterface::class)::find($orderId);

        $this->assertEquals($findOrder->getId(), $orderId);
    }

    /** @test * */
    public function found_nonexistent_order_returns_null()
    {
        $findOrder = app()->make(OrderInterface::class)::find(999);
        $this->assertEquals($findOrder, null);
    }

    /** @test * */
    public function found_order_with_order_lines()
    {
        $order = factory(OrderModel::class)->create();
        $orderId = $order->id;

        $orderLine = factory(OrderLineModel::class)->create([
            'order_id' => $orderId
        ]);
        $orderLineId = $orderLine->id;

        $findOrder = app()->make(OrderInterface::class)::find($orderId);

        $findOrderLines = $findOrder->getLines();

        $this->assertFalse(is_null($findOrderLines));
        $this->assertTrue(is_a($findOrderLines[0], OrderLineInterface::class));
        $this->assertEquals($orderLineId, $findOrderLines[0]->getId());
    }

    /** @test **/
    public function check_delivery_address_and_billing_data()
    {
        $order = factory(OrderModel::class)->create();
        $orderId = $order->id;

        $findOrder = app()->make(OrderInterface::class)::find($orderId);

        $deliveryAddress = $findOrder->getDeliveryAddress();
        
        $this->assertNotNull($deliveryAddress);
        $this->assertTrue(is_a($deliveryAddress, DeliveryAddress::class));

        $billingData = $findOrder->getBillingData();

        $this->assertNotNull($billingData);
        $this->assertTrue(is_a($billingData, BillingData::class));
    }

    /** @test **/
    public function check_creation_date()
    {
        $order = factory(OrderModel::class)->create();
        $orderId = $order->id;

        $findOrder = app()->make(OrderInterface::class)::find($orderId);

        $this->assertEquals($order->created_at, $findOrder->getCreationDate());
    }

    /** @test **/
    public function check_if_code_is_the_same()
    {
        $order = factory(OrderModel::class)->create();
        $orderId = $order->id;

        $findOrder = app()->make(OrderInterface::class)::find($orderId);

        $this->assertEquals($order->code, $findOrder->getCode());
    }

}