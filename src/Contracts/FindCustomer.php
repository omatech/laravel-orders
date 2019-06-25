<?php

namespace Omatech\LaravelOrders\Contracts;


interface FindCustomer
{
    public function make(int $id, string $where = null);
}