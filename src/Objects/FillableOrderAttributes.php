<?php

namespace Omatech\LaravelOrders\Objects;

use Omatech\LaravelOrders\Contracts\FillableOrderAttributes as FillableOrderAttributesInterface;
use Omatech\LaravelOrders\Models\Order;

class FillableOrderAttributes implements FillableOrderAttributesInterface
{
    private $model;

    /**
     * FillableOrderAttributes constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->model = $order;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->model->getFillable();
    }
}