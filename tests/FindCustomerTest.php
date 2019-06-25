<?php

namespace Omatech\LaravelOrders\Tests;

use Omatech\LaravelOrders\Contracts\Customer;

class FindCustomerTest extends BaseTestCase
{

    protected function setUp(): void
    {
        $this->enableUsersTests = [
            'found_existing_customer_by_user_id',
            'found_nonexistent_customer_by_user_id_returns_null'
        ];

        parent::setUp();
    }

    /** @test * */
    public function found_existing_customer()
    {
        $customer = app()->make(Customer::class);
        $customer->save();

        $findCustomer = app()->make(Customer::class)::find($customer->getId());

        $this->assertEquals($findCustomer->getId(), $customer->getId());
    }

    /** @test * */
    public function found_nonexistent_customer_returns_null()
    {
        $findCustomer = app()->make(Customer::class)::find(999);
        $this->assertEquals($findCustomer, null);
    }

    /** @test * */
    public function found_existing_customer_by_user_id()
    {
        $customer = app()->make(Customer::class);
        $customer->setUserId(1);
        $customer->save();

        $findCustomer = app()->make(Customer::class)::findByUserId($customer->getUserId());

        $this->assertEquals($findCustomer->getId(), $customer->getId());
    }

    /** @test * */
    public function found_nonexistent_customer_by_user_id_returns_null()
    {
        $findCustomer = app()->make(Customer::class)::findByUserId(999);
        $this->assertEquals($findCustomer, null);
    }
}