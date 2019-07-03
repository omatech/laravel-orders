<?php

namespace Omatech\LaravelOrders\Contracts;

interface SaveOrder
{
    public function save(Order $order): void;
}