<?php

namespace Omatech\LaravelOrders\Repositories\Cart;

use Omatech\LaravelOrders\Contracts\BillingData;
use Omatech\LaravelOrders\Contracts\Cart;
use Omatech\LaravelOrders\Contracts\DeliveryAddress;
use Omatech\LaravelOrders\Contracts\FindCart as FindCartInterface;
use Omatech\LaravelOrders\Contracts\Product;
use Omatech\LaravelOrders\Repositories\CartRepository;

class FindCart extends CartRepository implements FindCartInterface
{
    private $cart;
    private $deliveryAddress;
    /**
     * @var Product
     */
    private $product;
    /**
     * @var BillingData
     */
    private $billingData;

    /**
     * FindCart constructor.
     *
     * @param BillingData $billingData
     * @param Cart $cart
     * @param DeliveryAddress $deliveryAddress
     * @param Product $product
     * @throws \Exception
     */
    public function __construct(
        BillingData $billingData,
        Cart $cart,
        DeliveryAddress $deliveryAddress,
        Product $product
    )
    {
        parent::__construct();
        $this->billingData = $billingData;
        $this->cart = $cart;
        $this->deliveryAddress = $deliveryAddress;
        $this->product = $product;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function make(int $id): ?Cart
    {
        $cart = $this->model->with('cartLines')->find($id);

        if (is_null($cart)) {
            return null;
        }

        $attributes = $cart->getAttributes();

        //Delivery Address
        $deliveryAddressFields = [];

        foreach ($attributes as $attributeKey => $attributeValue) {
            if (strpos($attributeKey, 'delivery_address_') === 0) {
                $deliveryAddressFields[str_replace("delivery_address_", "", $attributeKey)] = $attributeValue;
            }
        }

        $deliveryAddress = $this->deliveryAddress->load($deliveryAddressFields);

        //Billing Data
        $billingDataFields = [];

        foreach ($attributes as $attributeKey => $attributeValue) {
            if (strpos($attributeKey, 'billing_') === 0) {
                $billingDataFields[str_replace("billing_", "", $attributeKey)] = $attributeValue;
            }
        }

        $billingData = $this->billingData->load($billingDataFields);

        //Products
        $cartLines = $cart->cartLines()->get();

        foreach ($cartLines as $cartLine) {
            $currentProduct = $this->product->load([
                'id' => $cartLine->product_id,
                'requestedQuantity' => $cartLine->quantity
            ]);

            $this->cart->push($currentProduct);
        }

        //Load all to a new Cart Object
        $this->cart->load($cart->toArray());
        $this->cart->setDeliveryAddress($deliveryAddress);
        $this->cart->setBillingData($billingData);

        return $this->cart;
    }
}