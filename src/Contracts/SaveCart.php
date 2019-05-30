<?php

namespace Omatech\LaravelOrders\Contracts;


interface SaveCart
{
    public function save(Cart &$cart);
}