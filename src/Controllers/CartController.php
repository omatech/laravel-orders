<?php

namespace Omatech\LaravelOrders\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Omatech\LaravelOrders\Contracts\Cart;
use Omatech\LaravelOrders\Middleware\ThrowErrorIfSessionCartIdNotExists;
use Omatech\LaravelOrders\Requests\AddProductToCartRequest;
use Omatech\LaravelOrders\Requests\AssignADeliveryAddressToCart;


class CartController extends Controller
{
    protected $cart;
    protected $currentCartId;

    /**
     * CheckoutController constructor.
     * @param Cart $cart
     */
    public function __construct(Cart $cart)
    {
        $this->middleware([ThrowErrorIfSessionCartIdNotExists::class])
            ->only(['assignDeliveryAddress']);

        $this->currentCartId = session('orders.current_cart.id');

        $this->cart = $this->currentCartId ? $cart::find($this->currentCartId) : $cart;
    }

    /**
     * @param AddProductToCartRequest $request
     */
    public function addProduct(AddProductToCartRequest $request)
    {
        $product = $request->get('product');

        $this->cart->push($product);

        $this->cart->save();

        if (is_null($this->currentCartId)) {
            session(['orders.current_cart.id' => $this->cart->getId()]);
        }
    }


    /**
     * @param AssignADeliveryAddressToCart $request
     * @return RedirectResponse
     */
    public function assignDeliveryAddress(AssignADeliveryAddressToCart $request)
    {
        $deliveryAddress = $request->get('delivery_address');

        $this->cart->setDeliveryAddress($deliveryAddress);

        $this->cart->save();

        $redirect = $request->get('redirect');

        if (is_a($redirect, RedirectResponse::class)) {
            return $redirect;
        }
    }
}