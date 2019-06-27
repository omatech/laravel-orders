<?php

namespace Omatech\LaravelOrders\Tests;


use Omatech\LaravelOrders\Models\Customer;

class CheckCustomerModelRelationshipsTest extends BaseTestCase
{
    protected $model;

    protected function setUp(): void
    {
        $this->enableUsersTests = [
            'user_relationship_exists_when_is_enabled'
        ];

        parent::setUp();
    }

    /** @test **/
    public function user_relationship_not_exists_when_is_not_enabled()
    {
        $this->assertFalse(app()->make(Customer::class)::hasMacro('user'));
    }

    /** @test **/
    public function user_relationship_exists_when_is_enabled()
    {
        $this->assertTrue(app()->make(Customer::class)::hasMacro('user'));
    }

}