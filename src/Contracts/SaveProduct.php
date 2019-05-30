<?php

namespace Omatech\LaravelOrders\Contracts;


interface SaveProduct
{
    public function save(Product &$product);
}