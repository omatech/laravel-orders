<?php

namespace Omatech\LaravelOrders\Repositories\Order;


use Omatech\LaravelOrders\Contracts\Order;
use Omatech\LaravelOrders\Contracts\OrderCode;
use Omatech\LaravelOrders\Repositories\OrderRepository;

class FindAllOrders extends OrderRepository implements \Omatech\LaravelOrders\Contracts\FindAllOrders
{
    /**
     * @var Order
     */
    private $order;

    /**
     * FindAllOrders constructor.
     * @param Order $order
     * @throws \Exception
     */
    public function __construct(Order $order)
    {
        parent::__construct();
        $this->order = $order;
    }

    /**
     * @return array
     */
    public function make(): array
    {
        $return = [];
        $all = $this->model->all();

        if (empty($all)) {
            return $return;
        }

        foreach ($all as $value) {
            $order = $this->order;
            $orderCode = app(OrderCode::class, ['code' => $value->code]);
            $order->setCode($orderCode);
            array_push($return, $order->fromArray($value->toArray()));
        }

        return $return;
    }
}