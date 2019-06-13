<?php

namespace Omatech\LaravelOrders\Repositories\Cart;

use Illuminate\Support\Arr;
use Omatech\LaravelOrders\Contracts\Cart;
use Omatech\LaravelOrders\Contracts\DeliveryAddress;
use Omatech\LaravelOrders\Repositories\CartRepository;

class FindCart extends CartRepository implements \Omatech\LaravelOrders\Contracts\FindCart
{
    private $cart;
    private $deliveryAddress;

    /**
     * FindCart constructor.
     * @param Cart $cart
     * @param DeliveryAddress $deliveryAddress
     * @throws \Exception
     */
    public function __construct(Cart $cart, DeliveryAddress $deliveryAddress)
    {
        parent::__construct();
        $this->cart = $cart;
        $this->deliveryAddress = $deliveryAddress;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function make(int $id): ?Cart
    {
        $cart = $this->model->find($id);

        if(is_null($cart)){
            return null;
        }

        $attributes = $cart->getAttributes();
        $deliveryAddressFields = [];

        foreach ($attributes as $attributeKey => $attributeValue){
            if(strpos($attributeKey, 'delivery_address_') === 0){
                $deliveryAddressFields[str_replace("delivery_address_", "", $attributeKey)] = $attributeValue;
            }
        }

        $deliveryAddress = $this->deliveryAddress->load($deliveryAddressFields);

        $this->cart->load($cart->toArray());
        $this->cart->setDeliveryAddress($deliveryAddress);

        return $this->cart;
    }
}