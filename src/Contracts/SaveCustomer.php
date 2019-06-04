<?php

namespace Omatech\LaravelOrders\Contracts;


interface SaveCustomer
{
    public function save(Customer &$customer);
    public function saveIfNotExists(Customer &$customer);
}