<?php

namespace Omatech\LaravelOrders\Contracts;

interface Cart
{
    public static function find(int $id);

    public function setId($id);

    public function getId();

    public function setDeliveryAddress(DeliveryAddress $deliveryAddress);

    public function getDeliveryAddress();

    public function getBillingData();

    public function setBillingData(BillingData $billingData);

    public function load(array $data);

    public function save();

    public function setProductQuantity(Product $product);

    public function push(Product $product);

    public function pop(Product $product);

    public function getCartLines();

}