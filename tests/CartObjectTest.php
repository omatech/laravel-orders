<?php

namespace Omatech\LaravelOrders\Tests;

use Omatech\LaravelOrders\Contracts\BillingData;
use Omatech\LaravelOrders\Contracts\Cart;
use Omatech\LaravelOrders\Contracts\DeliveryAddress;
use Omatech\LaravelOrders\Contracts\Order;
use Omatech\LaravelOrders\Contracts\Product;

class CartObjectTest extends BaseTestCase
{
    /** @test * */
    public function transform_cart_to_order()
    {
        $cart = app()->make(Cart::class);
        $data = factory(\Omatech\LaravelOrders\Models\Cart::class)->make()->toArray();
        $cart->load($data);

        $product = app()->make(Product::class);
        $product->save();
        $product->setRequestedQuantity(4);

        $cart->push($product);

        $cart->setDeliveryAddress(app()->make(DeliveryAddress::class)->fromArray([
            'first_name' => 'Test',
            'last_name' => 'Test',
            'first_line' => 'Test',
            'second_line' => 'Test',
            'postal_code' => 'Test',
            'city' => 'Test',
            'region' => 'Test',
            'country' => 'Test',
            'is_a_company' => true,
            'company_name' => 'Test Company',
        ]));

        $cart->setBillingData(app()->make(BillingData::class)->fromArray([
            'address_first_name' => 'Test',
            'address_last_name' => 'Test',
            'address_first_line' => 'Test',
            'address_second_line' => 'Test',
            'address_postal_code' => 'Test',
            'address_city' => 'Test',
            'address_region' => 'Test',
            'address_country' => 'Test',
            'company_name' => 'Test Company',
            'cif' => '123456789A',
            'phone_number' => '698765432'
        ]));

        $cart->save();

        $order = $cart->toOrder();

        $this->assertTrue(is_a($order, Order::class));
        $this->assertEquals($order->getDeliveryAddress(), $cart->getDeliveryAddress());
        $this->assertEquals($order->getBillingData(), $cart->getBillingData());
    }

    /** @test * */
    public function transform_cart_with_lines_to_order_with_lines()
    {
        $cart = app()->make(Cart::class);
        $data = factory(\Omatech\LaravelOrders\Models\Cart::class)->make()->toArray();
        $cart->fromArray($data);

        $product = app()->make(Product::class);
        $product->setRequestedQuantity(4);
        $product->setUnitPrice(1.99);
        $product->save();

        $cart->push($product);

        $cart->save();

        $order = $cart->toOrder();
        $lines = $order->getLines();

        $this->assertEquals(1, count($lines));
        $this->assertEquals(4, $lines[0]->getQuantity());
        $this->assertEquals(1.99, $lines[0]->getUnitPrice());
        $this->assertEquals(4*1.99, $lines[0]->getTotalPrice());
    }
}