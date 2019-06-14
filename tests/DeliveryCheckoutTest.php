<?php

namespace Omatech\LaravelOrders\Tests;

use Omatech\LaravelOrders\Contracts\Cart;
use Omatech\LaravelOrders\Contracts\DeliveryAddress;

class DeliveryCheckoutTest extends BaseTestCase
{
    /** @test */
    public function the_route_status_is_200()
    {
        $cart = app()->make(Cart::class);
        $cart->save();

        $this->withSession(['orders.current_cart.id' => $cart->getId()])
            ->get(route('orders.checkout.delivery'))
            ->assertStatus(200)
            ->assertViewIs('laravel-orders::pages.checkout.delivery');
    }

    /** @test */
    public function basic_inputs()
    {
        $data = [
            'first_name' => 'Testfirst_name',
            'last_name' => 'Testlast_name',
            'first_line' => 'Testfirst_line',
            'second_line' => 'Testsecond_line',
            'postal_code' => 'Testpostal_code',
            'city' => 'Testcity',
            'region' => 'Testregion',
            'country' => 'Testcountry',
            'is_a_company' => true,
            'company_name' => 'Test Companycompany_name',
        ];
        $deliveryAddress = app()->make(DeliveryAddress::class)->load($data);

        $cart = app()->make(Cart::class);
        $cart->setDeliveryAddress($deliveryAddress);
        $cart->save();

        $response = $this->withSession(['orders.current_cart.id' => $cart->getId()])
            ->get(route('orders.checkout.delivery'));


        foreach($data as $datumKey => $datum){
            $response->assertSee($datumKey);
            $response->assertSee($datum);
        }
    }
}