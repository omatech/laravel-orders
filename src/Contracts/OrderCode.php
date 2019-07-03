<?php

namespace Omatech\LaravelOrders\Contracts;

interface OrderCode
{
    public function get(): string;
}