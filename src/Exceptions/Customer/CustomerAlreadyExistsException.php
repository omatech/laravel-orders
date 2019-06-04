<?php

namespace Omatech\LaravelOrders\Exceptions\Customer;

use Omatech\LaravelOrders\Exceptions\BaseException;

class CustomerAlreadyExistsException extends BaseException
{
    /**
     * CustomerAlreadyExistsException constructor.
     */
    public function __construct()
    {
        parent::__construct('Current customer already exists', 500);
    }
}