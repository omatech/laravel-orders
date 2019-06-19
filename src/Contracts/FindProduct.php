<?php

namespace Omatech\LaravelOrders\Contracts;

interface FindProduct
{
    public function make(int $id);
}