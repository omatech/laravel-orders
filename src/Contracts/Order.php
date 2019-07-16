<?php

namespace Omatech\LaravelOrders\Contracts;


interface Order
{
    public static function find(int $id);
}