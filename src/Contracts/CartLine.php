<?php

namespace Omatech\LaravelOrders\Contracts;


interface CartLine
{
    public function load(array $data);
}