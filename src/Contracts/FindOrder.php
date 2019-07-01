<?php

namespace Omatech\LaravelOrders\Contracts;


interface FindOrder
{
    public function make(int $id);
}