<?php

namespace Omatech\LaravelOrders\Repositories\Order;

use Omatech\LaravelOrders\Contracts\Order;
use Omatech\LaravelOrders\Contracts\SaveOrder as SaveOrderInterface;
use Omatech\LaravelOrders\Repositories\OrderRepository;

class SaveOrder extends OrderRepository implements SaveOrderInterface
{

    /**
     * @param Order $order
     */
    public function save(Order $order): void
    {
        $model = $this->model;
        $data = $order->toArray();

        if (!is_null($order->getId())) {
            $model = $model->find($data['id']);

            if (is_null($model)) {
                unset($data['id']);
                $model = $this->model->create([
                    'code' => $order->getCode()
                ]);
            }
        }

        if (isset($data['delivery_address'])) {
            foreach ($data['delivery_address'] as $deliveryAddressDatumKey => $deliveryAddressDatumValue){
                $data['delivery_address_'.$deliveryAddressDatumKey] = $deliveryAddressDatumValue;
            }
            unset($data['delivery_address']);
        }
        if (isset($data['billing_data'])) {
            foreach ($data['billing_data'] as $billingDataDatumKey => $billingDataDatumValue){
                $data['billing_'.$billingDataDatumKey] = $billingDataDatumValue;
            }
            unset($data['billing_data']);
        }

        $model->fill($data);

        $model->saveOrFail();

        $order->setId($model->id);

        $orderLines = $order->getLines();
        foreach ($orderLines as $orderLine) {
            $currentLineQuantity = $orderLine->getQuantity();
            if ($currentLineQuantity > 0) {

                $model->orderLines()->create([
                    'quantity' => $currentLineQuantity,
                    'order_id' => $order->getId(),
                ], [
                    'id' => $orderLine->getId(),
                    'quantity' => $orderLine->getQuantity(),
                    'unit_price' => $orderLine->getUnitPrice(),
                    'total_price' => $orderLine->getTotalPrice()
                ]);

            }
        }
    }

}