<?php

namespace Omatech\LaravelOrders\Contracts;

interface FillableOrderAttributes
{
    public function get(): array;
}