<?php

namespace Omatech\LaravelOrders\Tests;

use Omatech\LaravelOrders\Contracts\FindAllCustomers;
use Omatech\LaravelOrders\Models\Customer;

class FindAllCustomersTest extends BaseTestCase
{
    /** @test * */
    public function check_if_we_can_find_all_customers()
    {
        $customers = factory(Customer::class, 10)->create()->toArray();

        $findCustomers = app(FindAllCustomers::class)->make();

        $this->assertTrue(is_array($findCustomers));
        $this->assertEquals(10, count($findCustomers));
        $firstNames = array_column($customers, 'first_name');

        foreach ($findCustomers as $customer) {
            $this->assertTrue(array_search($customer->getFirstName(), $firstNames) !== false);
        }
    }

    /** @test * */
    public function call_find_all_statically_from_customer_object()
    {
        $customers = factory(Customer::class, 10)->create()->toArray();

        $findCustomers = app(\Omatech\LaravelOrders\Contracts\Customer::class)::findAll();

        $this->assertTrue(is_array($findCustomers));
        $this->assertEquals(10, count($findCustomers));
        $firstNames = array_column($customers, 'first_name');

        foreach ($findCustomers as $customer) {
            $this->assertTrue(array_search($customer->getFirstName(), $firstNames) !== false);
        }
    }

}