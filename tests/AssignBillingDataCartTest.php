<?php

namespace Omatech\LaravelOrders\Tests;

use Omatech\LaravelOrders\Contracts\BillingData;
use Omatech\LaravelOrders\Contracts\Cart;

class AssignBillingDataCartTest extends BaseTestCase
{
    protected $object;
    protected $example;

    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = app()->make(BillingData::class);
        $this->example = $this->object->load([
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
        ]);
    }

    /** @test * */
    public function check_billing_data_is_assigned_to_cart()
    {
        $cart = tap(app()->make(Cart::class))->save();
        $billingData = $this->example;

        $cart->setBillingData($billingData);
        $cart->save();

        $findCart = app()->make(Cart::class)::find($cart->getId());

        $findBillingData = $findCart->getBillingData();

        $this->assertFalse(is_null($findBillingData));
        $this->assertTrue(is_a($findBillingData, BillingData::class));
        $this->assertEquals($billingData, $findBillingData);
    }

    /** @test * */
    public function check_billing_data_is_saved_in_database()
    {
        $cart = tap(app()->make(Cart::class))->save();
        $billingData = $this->example;

        $cart->setBillingData($billingData);
        $cart->save();

        $this->assertDatabaseHas('carts', [
            'id' => $cart->getId(),
            'billing_address_first_name' => $billingData->getAddressFirstName(),
            'billing_address_last_name' => $billingData->getAddressLastName(),
            'billing_address_first_line' => $billingData->getAddressFirstLine(),
            'billing_address_second_line' => $billingData->getAddressSecondLine(),
            'billing_address_postal_code' => $billingData->getAddressPostalCode(),
            'billing_address_city' => $billingData->getAddressCity(),
            'billing_address_region' => $billingData->getAddressRegion(),
            'billing_address_country' => $billingData->getAddressCountry(),
            'billing_company_name' => $billingData->getCompanyName(),
            'billing_cif' => $billingData->getCif(),
            'billing_phone_number' => $billingData->getPhoneNumber(),
        ]);
    }

    /** @test * */
    public function try_to_assign_an_incorrect_billing_data_object()
    {
        $this->expectException(\Throwable::class);

        $cart = tap(app()->make(Cart::class))->save();
        $billingData = (object)[
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
        ];

        $cart->setBillingData($billingData);
        $cart->save();

        $this->assertDatabaseMissing('carts', [
            'id' => $cart->getId(),
            'billing_address_first_name' => $billingData->address_first_name,
            'billing_address_last_name' => $billingData->address_last_name,
            'billing_address_first_line' => $billingData->address_first_line,
            'billing_address_second_line' => $billingData->address_second_line,
            'billing_address_postal_code' => $billingData->address_postal_code,
            'billing_address_city' => $billingData->address_city,
            'billing_address_region' => $billingData->address_region,
            'billing_address_country' => $billingData->address_country,
            'billing_company_name' => $billingData->company_name,
            'billing_cif' => $billingData->cif,
            'billing_phone_number' => $billingData->phone_number,
        ]);
    }
}