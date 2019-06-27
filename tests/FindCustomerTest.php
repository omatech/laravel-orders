<?php

namespace Omatech\LaravelOrders\Tests;

use Omatech\LaravelOrders\Contracts\Customer;
use Omatech\LaravelOrders\Models\Order;

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

    /** @test **/
    public function found_existent_customer_with_orders()
    {
        $customer = app()->make(Customer::class);
        $customer->save();
        $numFakeOrders = 5;

        factory(Order::class, $numFakeOrders)->create([
            'customer_id' => $customer->getId()
        ]);

        $findCustomer = app()->make(Customer::class)::find($customer->getId());
        $orders = $findCustomer->getOrders();

        $this->assertTrue(is_array($orders));
        $this->assertTrue(!empty($orders));
        $this->assertTrue(count($orders) == $numFakeOrders);
        $this->assertTrue(is_a($orders[0], \Omatech\LaravelOrders\Contracts\Order::class));
    }
}