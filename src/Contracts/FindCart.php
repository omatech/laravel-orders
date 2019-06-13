<?php

namespace Omatech\LaravelOrders\Contracts;


interface FindCart
{
    public function make(int $id);
}