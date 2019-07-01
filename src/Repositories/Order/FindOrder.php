<?php

namespace Omatech\LaravelOrders\Repositories\Order;

use Omatech\LaravelOrders\Contracts\Order;
use Omatech\LaravelOrders\Contracts\OrderLine;
use Omatech\LaravelOrders\Repositories\OrderRepository;

class FindOrder extends OrderRepository
{
    /**
     * @var Order
     */
    private $order;
    /**
     * @var OrderLine
     */
    private $orderLine;

    /**
     * FindOrder constructor.
     *
     * @param Order $order
     * @param OrderLine $orderLine
     * @throws \Exception
     */
    public function __construct(
        Order $order,
        OrderLine $orderLine
    )
    {
        parent::__construct();
        $this->order = $order;
        $this->orderLine = $orderLine;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function make(int $id): ?Order
    {
        $order = $this->model->with('orderLines')->find($id);

        if (is_null($order)) {
            return null;
        }

        //Order Lines
        $orderLines = $order->orderLines()->get();

        foreach ($orderLines as $orderLine) {
            $currentOrderLine = $this->orderLine->fromArray([
                'id' => $orderLine->id,
                'quantity' => $orderLine->quantity
            ]);

            $this->order->pushLine($currentOrderLine);
        }

        //Load all to a new Order Object
        $this->order->fromArray($order->toArray());

        return $this->order;
    }
}