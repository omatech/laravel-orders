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
        $data = $order->toArray();

        $model = $this->getModel($order, $data);
        $this->prepareDeliveryAddressFields($data);
        $this->prepareBillingDataFields($data);

        $model->fill($data);

        $model->saveOrFail();

        $order->setId($model->id);

        $orderLines = $order->getLines();
        foreach ($orderLines as $orderLine) {
            $currentLine = null;
            $currentLineQuantity = $orderLine->getQuantity();
            if ($currentLineQuantity > 0) {

                $currentLine = array_merge($orderLine->toArray(), [
                    'id' => $orderLine->getId(),
                    'order_id' => $order->getId(),
                    'quantity' => $orderLine->getQuantity(),
                    'unit_price' => $orderLine->getUnitPrice(),
                    'total_price' => $orderLine->getTotalPrice(),
                    'product_id' => $orderLine->getProductId()
                ]);

                $this->prepareProductFields($currentLine);

                $model->orderLines()->updateOrCreate([
                    'id' => $orderLine->getId(),
                    'order_id' => $order->getId(),
                    'product_id' => $orderLine->getProductId()
                ], $currentLine);

            }
        }
    }

    /**
     * @param $order
     * @param $data
     * @return mixed
     */
    private function getModel($order, &$data){
        $model = $this->model;

        if (!is_null($order->getId())) {
            $model = $model->find($data['id']);

            if (is_null($model)) {
                unset($data['id']);
                $model = $this->model->create([
                    'code' => $order->getCode()
                ]);
            }
        }

        return $model;
    }

    /**
     * @param $data
     */
    private function prepareDeliveryAddressFields(&$data)
    {
        if (isset($data['delivery_address'])) {
            foreach ($data['delivery_address'] as $deliveryAddressDatumKey => $deliveryAddressDatumValue){
                $data['delivery_address_'.$deliveryAddressDatumKey] = $deliveryAddressDatumValue;
            }
            unset($data['delivery_address']);
        }
    }

    /**
     * @param $data
     */
    private function prepareBillingDataFields(&$data)
    {
        if (isset($data['billing_data'])) {
            foreach ($data['billing_data'] as $billingDataDatumKey => $billingDataDatumValue){
                $data['billing_'.$billingDataDatumKey] = $billingDataDatumValue;
            }
            unset($data['billing_data']);
        }
    }

    /**
     * @param $data
     */
    private function prepareProductFields(&$data)
    {
        if (isset($data['product'])) {
            foreach ($data['product'] as $productDatumKey => $productDatumValue){
                if(is_array($productDatumValue))
                    $productDatumValue = json_encode($productDatumValue);

                $data['product_'.$productDatumKey] = $productDatumValue;
            }
            unset($data['product']);
        }
    }

}