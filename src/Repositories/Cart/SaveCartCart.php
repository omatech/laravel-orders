<?php

namespace Omatech\LaravelOrders\Repositories\Cart;

use Illuminate\Support\Facades\Validator;
use Omatech\LaravelOrders\Contracts\Cart;
use Omatech\LaravelOrders\Contracts\SaveCart;
use Omatech\LaravelOrders\Repositories\CartRepository;

class SaveCartCart extends CartRepository implements SaveCart //TODO canviar el nom de la classe
{

    /**
     * @param Cart $cart
     */
    public function save(Cart &$cart)
    {
        $model = $this->model;

        if (!is_null($cart->getId())) {
            $model = $model->find($cart->getId());

            if (is_null($model)) {
                $model = $this->model->create();
            }
        }

        $cartToArray = $cart->toArray();
        $deliveryAddress = $cartToArray['deliveryAddress'];

        if (!is_null($deliveryAddress) && is_array($deliveryAddress)) {
            unset($cartToArray['deliveryAddress']);
            foreach ($deliveryAddress as $deliveryAddressField => $deliveryAddressValue) {
                if (!is_null($deliveryAddressValue)) {
                    $cartToArray['delivery_address_' . $deliveryAddressField] = $deliveryAddressValue;
                }
            }
        }

        $billingData = $cartToArray['billingData'];

        if (!is_null($billingData) && is_array($billingData)) {
            unset($cartToArray['billingData']);
            foreach ($billingData as $billingDataField => $billingDataValue) {
                if (!is_null($billingDataValue)) {
                    $cartToArray['billing_' . $billingDataField] = $billingDataValue;
                }
            }
        }

        $model->fill($cartToArray);
        $model->saveOrFail();

        $cart->setId($model->id);

        $cartLines = $cart->products();
        foreach ($cartLines as $cartLine) {
            $currentProduct = $cartLine->toArray();
            $currentProduct['cart_id'] = $cart->getId();

            $validated = config('laravel-orders.options.products.enabled') ? Validator::make([
                'product_id' => $currentProduct['product_id'],
            ], [
                'product_id' => 'exists:products,id',
            ])->passes() : true;

            if ($validated) {

                if ($currentProduct['quantity'] > 0) {

                    $model->cartLines()->updateOrCreate([
                        'product_id' => $currentProduct['product_id'],
                        'cart_id' => $currentProduct['cart_id'],
                    ], $currentProduct);

                } else {
                    $model->cartLines()
                        ->where('product_id', $currentProduct['product_id'])
                        ->where('cart_id', $currentProduct['cart_id'])
                        ->delete();

                    $cart->pop($cartLine->toProduct());
                }
            }

        }

    }
}