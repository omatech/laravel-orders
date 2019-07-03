<?php

namespace Omatech\LaravelOrders\Tests;

use Omatech\LaravelOrders\Contracts\OrderCode;

class OrderCodeObjectTest extends BaseTestCase
{
    /** @test **/
    public function get_returns_random_code()
    {
        $code = app()->make(OrderCode::class)->get();

        $this->assertNotEmpty($code);
    }

}