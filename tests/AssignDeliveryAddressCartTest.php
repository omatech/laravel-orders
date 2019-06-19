<?php

namespace Omatech\LaravelOrders\Tests;

use Omatech\LaravelOrders\Contracts\Cart;
use Omatech\LaravelOrders\Contracts\DeliveryAddress;

class AssignDeliveryAddressCartTest extends BaseTestCase
{
    protected $object;
    protected $example;

    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = app()->make(DeliveryAddress::class);
        $this->example = $this->object->load([
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
        ]);
    }

    /** @test * */
    public function check_delivery_address_is_assigned_to_cart()
    {
        $cart = tap(app()->make(Cart::class))->save();
        $deliveryAddress = $this->example;

        $cart->setDeliveryAddress($deliveryAddress);
        $cart->save();

        $findCart = app()->make(Cart::class)::find($cart->getId());

        $findDeliveryAddress = $findCart->getDeliveryAddress();

        $this->assertFalse(is_null($findDeliveryAddress));
        $this->assertTrue(is_a($findDeliveryAddress, DeliveryAddress::class));
        $this->assertEquals($deliveryAddress, $findDeliveryAddress);
    }

    /** @test * */
    public function check_delivery_address_is_saved_in_database()
    {
        $cart = tap(app()->make(Cart::class))->save();
        $deliveryAddress = $this->example;

        $cart->setDeliveryAddress($deliveryAddress);
        $cart->save();

        $this->assertDatabaseHas('carts', [
            'id' => $cart->getId(),
            'delivery_address_first_name' => $deliveryAddress->getFirstName(),
            'delivery_address_last_name' => $deliveryAddress->getLastName(),
            'delivery_address_first_line' => $deliveryAddress->getFirstLine(),
            'delivery_address_second_line' => $deliveryAddress->getSecondLine(),
            'delivery_address_postal_code' => $deliveryAddress->getPostalCode(),
            'delivery_address_city' => $deliveryAddress->getCity(),
            'delivery_address_region' => $deliveryAddress->getRegion(),
            'delivery_address_country' => $deliveryAddress->getCountry(),
            'delivery_address_is_a_company' => $deliveryAddress->getIsACompany(),
            'delivery_address_company_name' => $deliveryAddress->getCompanyName(),
        ]);
    }

    /** @test * */
    public function try_to_assign_an_incorrect_delivery_address_object()
    {
        $this->expectException(\Throwable::class);

        $cart = tap(app()->make(Cart::class))->save();
        $deliveryAddress = (object)[
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
        ];

        $cart->setDeliveryAddress($deliveryAddress);
        $cart->save();

        $this->assertDatabaseMissing('carts', [
            'id' => $cart->getId(),
            'delivery_address_first_name' => $deliveryAddress->first_name,
            'delivery_address_last_name' => $deliveryAddress->last_name,
            'delivery_address_first_line' => $deliveryAddress->first_line,
            'delivery_address_second_line' => $deliveryAddress->second_line,
            'delivery_address_postal_code' => $deliveryAddress->postal_code,
            'delivery_address_city' => $deliveryAddress->city,
            'delivery_address_region' => $deliveryAddress->region,
            'delivery_address_country' => $deliveryAddress->country,
            'delivery_address_is_a_company' => $deliveryAddress->is_a_company,
            'delivery_address_company_name' => $deliveryAddress->company_name,
        ]);
    }
}