<?php

namespace Omatech\LaravelOrders\Exceptions\Order;

use Omatech\LaravelOrders\Exceptions\BaseException;

class CreateOrderException extends BaseException
{
    /**
     * CreateOrderException constructor.
     */
    public function __construct()
    {
        parent::__construct('Order Not Created', 500);
    }
}