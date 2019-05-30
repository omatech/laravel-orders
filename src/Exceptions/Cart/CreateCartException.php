<?php
namespace Omatech\LaravelOrders\Exceptions\Cart;

use Omatech\LaravelOrders\Exceptions\BaseException;

class CreateCartException extends BaseException
{
    /**
     */
    public function __construct()
    {
        parent::__construct('Cart Not Created');
    }
}