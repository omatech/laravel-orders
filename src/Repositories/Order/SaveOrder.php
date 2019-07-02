<?php

namespace Omatech\LaravelOrders\Repositories\Order;

use Omatech\LaravelOrders\Contracts\Order;
use Omatech\LaravelOrders\Repositories\OrderRepository;
use Omatech\LaravelOrders\Contracts\SaveOrder as SaveOrderInterface;

class SaveOrder extends OrderRepository implements SaveOrderInterface
{

    public function save(Order $order)
    {
        $model = $this->model;

        if (!is_null($order->getId())) {
            $model = $model->find($order->getId());

            if (is_null($model)) {
                $model = $this->model->create();
            }
        }

        $model->fill($order->toArray());

        $model->saveOrFail();

        $order->setId($model->id);

        $orderLines = $order->getLines();
        foreach ($orderLines as $orderLine) {
            $currentLineQuantity = $orderLine->getQuantity();
            if ($currentLineQuantity > 0) {

                $model->orderLines()->create([
                    'quantity' => $currentLineQuantity,
                    'order_id' => $order->getId(),
                ], $orderLine->toArray());

            }
        }
    }

}