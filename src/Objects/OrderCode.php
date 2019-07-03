<?php

namespace Omatech\LaravelOrders\Objects;

use Illuminate\Support\Str;
use Omatech\LaravelOrders\Contracts\OrderCode as OrderCodeInterface;

class OrderCode implements OrderCodeInterface
{
    private $code;

    /**
     * OrderCode constructor.
     */
    public function __construct()
    {
        $this->code = Str::random(5) . time();
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->code;
    }
}