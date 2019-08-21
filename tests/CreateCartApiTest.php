<?php

namespace Omatech\LaravelOrders\Tests;

use Omatech\LaravelOrders\Api\Cart;

class CreateCartApiTest extends BaseTestCase
{
    /** @test * */
    public function save_a_new_cart_in_database()
    {
        $data = factory(\Omatech\LaravelOrders\Models\Cart::class)->make()->toArray();
        $cart = app()->make(Cart::class)->create($data);

        $this->assertFalse(empty($cart->getId()));

        $this->assertTrue(is_a($cart, \Omatech\LaravelOrders\Objects\Cart::class));

        $this->assertDatabaseHas('carts', [
            'id' => $cart->getId(),
            'delivery_address_first_name' => $data['delivery_address_first_name'],
            'delivery_address_last_name' => $data['delivery_address_last_name'],
            'delivery_address_first_line' => $data['delivery_address_first_line'],
            'delivery_address_second_line' => $data['delivery_address_second_line'],
            'delivery_address_postal_code' => $data['delivery_address_postal_code'],
            'delivery_address_city' => $data['delivery_address_city'],
            'delivery_address_region' => $data['delivery_address_region'],
            'delivery_address_country' => $data['delivery_address_country'],
            'delivery_address_is_a_company' => $data['delivery_address_is_a_company'],
            'delivery_address_company_name' => $data['delivery_address_company_name'],
            'delivery_address_email' => $data['delivery_address_email'],
            'delivery_address_phone_number' => $data['delivery_address_phone_number'],
            'billing_address_first_name' => $data['billing_address_first_name'],
            'billing_address_last_name' => $data['billing_address_last_name'],
            'billing_address_first_line' => $data['billing_address_first_line'],
            'billing_address_second_line' => $data['billing_address_second_line'],
            'billing_address_postal_code' => $data['billing_address_postal_code'],
            'billing_address_city' => $data['billing_address_city'],
            'billing_address_region' => $data['billing_address_region'],
            'billing_address_country' => $data['billing_address_country'],
            'billing_company_name' => $data['billing_company_name'],
            'billing_cif' => $data['billing_cif'],
            'billing_phone_number' => $data['billing_phone_number'],
        ]);
    }

    /** @test * */
    public function save_empty_if_data_is_empty()
    {
        app()->make(Cart::class)->create();

        $this->assertDatabaseHas('carts', [
            'id' => 1,
            'delivery_address_first_name' => null,
            'delivery_address_last_name' => null,
            'delivery_address_first_line' => null,
            'delivery_address_second_line' => null,
            'delivery_address_postal_code' => null,
            'delivery_address_city' => null,
            'delivery_address_region' => null,
            'delivery_address_country' => null,
            'delivery_address_is_a_company' => 0,
            'delivery_address_company_name' => null,
            'delivery_address_email' => null,
            'delivery_address_phone_number' => null,
            'billing_address_first_name' => null,
            'billing_address_last_name' => null,
            'billing_address_first_line' => null,
            'billing_address_second_line' => null,
            'billing_address_postal_code' => null,
            'billing_address_city' => null,
            'billing_address_region' => null,
            'billing_address_country' => null,
            'billing_company_name' => null,
            'billing_cif' => null,
            'billing_phone_number' => null,
        ]);
    }
}