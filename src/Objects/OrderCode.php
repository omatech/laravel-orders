<?php

namespace Omatech\LaravelOrders\Objects;

use Illuminate\Support\Str;
use Omatech\LaravelOrders\Contracts\OrderCode as OrderCodeInterface;

class OrderCode implements OrderCodeInterface
{
    private $code;

    /**
     * OrderCode constructor.
     * @param null $code
     */
    public function __construct($code = null)
    {
        if (is_null($code) || !$this->validate($code)) {
            $code = $this->generate();
        }

        $this->code = $code;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->code;
    }

    /**
     * @param $code
     * @return bool
     */
    private function validate($code): bool
    {
        return true;
    }

    /**
     * @return string
     */
    private function generate(): string
    {
        return Str::random(5) . time();
    }
}