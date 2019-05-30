<?php

namespace Omatech\LaravelOrders\Repositories\Cart;

use Omatech\LaravelOrders\Contracts\Cart;
use Omatech\LaravelOrders\Contracts\SaveCart;
use Omatech\LaravelOrders\Repositories\CartRepository;

class SaveCartCart extends CartRepository implements SaveCart //TODO canviar el nom de la classe
{

    public function save(Cart &$cart)
    {
        $model = $this->model;

        if (!is_null($cart->getId())) {
            $model = $model->find($cart->getId());

            if (is_null($model)) {
                $model = $this->model->create();
            }
        }

        $model->fill($cart->toArray());

        $model->saveOrFail();

        $cart->setId($model->id);

        $cartLines = $cart->products();
        foreach ($cartLines as $cartLine) {
            $currentProduct = $cartLine->toArray();
            $currentProduct['cart_id'] = $cart->getId();

            if ($currentProduct['quantity'] > 0) {

                $model->cartLines()->updateOrCreate([
                    'product_id' => $currentProduct['product_id'],
                    'cart_id' => $currentProduct['cart_id']
                ], $currentProduct);

            }else{
                $model->cartLines()
                    ->where('product_id', $currentProduct['product_id'])
                    ->where('cart_id', $currentProduct['cart_id'])
                    ->delete();

                $cart->pop($cartLine->toProduct());
            }

        }

    }
}