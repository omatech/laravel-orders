<?php

namespace Omatech\LaravelOrders\Tests;


use Omatech\LaravelOrders\Contracts\BillingData;
use Omatech\LaravelOrders\Contracts\Cart;

class BillingCheckoutTest extends BaseTestCase
{
    /** @test */
    public function the_route_status_is_200()
    {
        $cart = app()->make(Cart::class);
        $cart->save();

        $this->withSession(['orders.current_cart.id' => $cart->getId()])
            ->get(route('orders.checkout.billing'))
            ->assertStatus(200)
            ->assertViewIs('laravel-orders::pages.checkout.billing');
    }

    /** @test */
    public function basic_inputs()
    {
        $data = [
            'address_first_name' => 'Testfirst_name',
            'address_last_name' => 'Testlast_name',
            'address_first_line' => 'Testfirst_line',
            'address_second_line' => 'Testsecond_line',
            'address_postal_code' => 'Testpostal_code',
            'address_city' => 'Testcity',
            'address_region' => 'Testregion',
            'address_country' => 'Testcountry',
            'company_name' => 'Test Companycompany_name',
            'cif' => '123456789A',
            'phone_number' => '698765432'
        ];
        $billingData = app()->make(BillingData::class)->load($data);

        $cart = app()->make(Cart::class);
        $cart->setBillingData($billingData);
        $cart->save();

        $response = $this->withSession(['orders.current_cart.id' => $cart->getId()])
            ->get(route('orders.checkout.billing'));


        foreach($data as $datumKey => $datum){
            $response->assertSee($datumKey);
            $response->assertSee($datum);
        }
    }
}