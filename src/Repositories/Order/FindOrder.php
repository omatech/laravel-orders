<?php

namespace Omatech\LaravelOrders\Repositories\Order;

use Omatech\LaravelOrders\Contracts\BillingData;
use Omatech\LaravelOrders\Contracts\DeliveryAddress;
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
     * @var BillingData
     */
    private $billingData;
    /**
     * @var DeliveryAddress
     */
    private $deliveryAddress;

    /**
     * FindOrder constructor.
     *
     * @param BillingData $billingData
     * @param DeliveryAddress $deliveryAddress
     * @param Order $order
     * @param OrderLine $orderLine
     * @throws \Exception
     */
    public function __construct(
        BillingData $billingData,
        DeliveryAddress $deliveryAddress,
        Order $order,
        OrderLine $orderLine
    )
    {
        parent::__construct();
        $this->order = $order;
        $this->orderLine = $orderLine;
        $this->billingData = $billingData;
        $this->deliveryAddress = $deliveryAddress;
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

        $attributes = $order->getAttributes();

        //Delivery Address
        $deliveryAddressFields = [];

        foreach ($attributes as $attributeKey => $attributeValue) {
            if (strpos($attributeKey, 'delivery_address_') === 0) {
                $deliveryAddressFields[str_replace("delivery_address_", "", $attributeKey)] = $attributeValue;
            }
        }

        $deliveryAddress = $this->deliveryAddress->fromArray($deliveryAddressFields);

        //Billing Data
        $billingDataFields = [];

        foreach ($attributes as $attributeKey => $attributeValue) {
            if (strpos($attributeKey, 'billing_') === 0) {
                $billingDataFields[str_replace("billing_", "", $attributeKey)] = $attributeValue;
            }
        }

        $billingData = $this->billingData->fromArray($billingDataFields);

        //Order Lines
        $orderLines = $order->orderLines()->get();

        foreach ($orderLines as $orderLine) {
            $currentOrderLine = $this->orderLine->fromArray([
                'id' => $orderLine->id,
                'quantity' => $orderLine->quantity,
                'unit_price' => $orderLine->unit_price,
                'total_price' => $orderLine->total_price
            ]);

            $this->order->pushLine($currentOrderLine);
        }

        //Load all to a new Order Object
        $this->order->fromArray($order->toArray());
        $this->order->setDeliveryAddress($deliveryAddress);
        $this->order->setBillingData($billingData);

        return $this->order;
    }
}