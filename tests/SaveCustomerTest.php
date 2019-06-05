<?php

namespace Omatech\LaravelOrders\Tests;


use Omatech\LaravelOrders\Contracts\Customer;
use Omatech\LaravelOrders\Contracts\DeliveryAddress;
use Omatech\LaravelOrders\Exceptions\Customer\CustomerAlreadyExistsException;

class SaveCustomerTest extends BaseTestCase
{
    /** @test * */
    public function saved_in_database()
    {
        $customer = app()->make(Customer::class);

        $data = [];
        $customer->load($data);
        $customer->save();

        $this->assertFalse(empty($customer->getId()));
        $this->assertDatabaseHas('customers', ['id' => $customer->getId()] + $data);

        $data = ['id' => 1];
        $customer->load($data);
        $customer->save();

        $this->assertFalse(empty($customer->getId()));
        $this->assertDatabaseHas('customers', ['id' => $customer->getId()] + $data);
    }

    /** @test * */
    public function saves_it_because_customer_not_exists()
    {
        $customer = app()->make(Customer::class);

        $data = [
            "first_name" => "Test Name",
            "last_name" => "Test last name",
            "birthday" => "2000-05-22",
            "phone_number" => "666666666",
        ];

        $customer->load($data);
        $customer->saveIfNotExists();

        $this->assertFalse(empty($customer->getId()));
        $this->assertDatabaseHas('customers', ['id' => $customer->getId()] + $data);
    }

    /** @test * */
    public function not_saves_it_because_customer_exists()
    {
        $this->expectException(CustomerAlreadyExistsException::class);

        $customer = app()->make(Customer::class);

        $data = [
            "first_name" => "Test Name",
            "last_name" => "Test last name",
            "birthday" => "2000-05-22",
            "phone_number" => "666666666",
        ];

        $customer->load($data);
        $customer->save();

        $this->assertDatabaseHas('customers', ['id' => $customer->getId()] + $data);

        $newCustomer = app()->make(Customer::class);
        $newCustomer->load($data);
        $newCustomer->saveIfNotExists();

        $this->assertTrue(empty($newCustomer->getId()));
    }

    /** @test **/
    public function save_a_new_delivery_address()
    {
        $customer = app()->make(Customer::class);

        $customerData = [
            "first_name" => "Test Name",
            "last_name" => "Test last name",
            "birthday" => "2000-05-22",
            "phone_number" => "666666666",
        ];

        $customer->load($customerData);

        $deliveryAddress = app()->make(DeliveryAddress::class);
        $deliveryAddressData = [
            'first_name' => $customerData['first_name'],
            'last_name' => $customerData['last_name'],
            'first_line' => 'Ronda Universitat 31',
            'second_line' => '5, 4',
            'postal_code' => '08007',
            'city' => 'Barcelona',
            'region' => 'Catalonia',
            'country' => 'ExampleCountry',
            'is_a_company' => true,
            'company_name' => 'OMA Technologies'
        ];

        $deliveryAddress->load($deliveryAddressData);

        $customer->setDeliveryAddress($deliveryAddress);

        $customer->save();

        $customer_id = $customer->getId();

        $this->assertFalse(is_null($customer_id));
        $this->assertDatabaseHas('customers', ['id' => $customer_id] + $customerData);
        $this->assertDatabaseHas('customer_delivery_addresses', ['customer_id' => $customer_id] + $deliveryAddressData);
    }
}