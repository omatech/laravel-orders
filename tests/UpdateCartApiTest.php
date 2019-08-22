<?php

namespace Omatech\LaravelOrders\Tests;

use Omatech\LaravelOrders\Api\Cart;

class UpdateCartApiTest extends BaseTestCase
{
    /** @test * */
    public function update_a_cart_in_database()
    {
        $data = factory(\Omatech\LaravelOrders\Models\Cart::class)->create([
            'delivery_address_is_a_company' => true,
            'delivery_address_company_name' => 'Test Company'
        ])->toArray();
        $dataToUpdate = factory(\Omatech\LaravelOrders\Models\Cart::class)->make([
            'delivery_address_is_a_company' => false,
            'delivery_address_company_name' => null,
        ])->toArray();
        $updated = app()->make(Cart::class)->update($data['id'], $dataToUpdate);

        $this->assertTrue($updated);

        $this->assertDatabaseHas('carts', [
            'id' => $data['id'],
            'delivery_address_first_name' => $dataToUpdate['delivery_address_first_name'],
            'delivery_address_last_name' => $dataToUpdate['delivery_address_last_name'],
            'delivery_address_first_line' => $dataToUpdate['delivery_address_first_line'],
            'delivery_address_second_line' => $dataToUpdate['delivery_address_second_line'],
            'delivery_address_postal_code' => $dataToUpdate['delivery_address_postal_code'],
            'delivery_address_city' => $dataToUpdate['delivery_address_city'],
            'delivery_address_region' => $dataToUpdate['delivery_address_region'],
            'delivery_address_country' => $dataToUpdate['delivery_address_country'],
            'delivery_address_is_a_company' => $dataToUpdate['delivery_address_is_a_company'],
            'delivery_address_company_name' => $dataToUpdate['delivery_address_company_name'],
            'delivery_address_email' => $dataToUpdate['delivery_address_email'],
            'delivery_address_phone_number' => $dataToUpdate['delivery_address_phone_number'],
            'billing_address_first_name' => $dataToUpdate['billing_address_first_name'],
            'billing_address_last_name' => $dataToUpdate['billing_address_last_name'],
            'billing_address_first_line' => $dataToUpdate['billing_address_first_line'],
            'billing_address_second_line' => $dataToUpdate['billing_address_second_line'],
            'billing_address_postal_code' => $dataToUpdate['billing_address_postal_code'],
            'billing_address_city' => $dataToUpdate['billing_address_city'],
            'billing_address_region' => $dataToUpdate['billing_address_region'],
            'billing_address_country' => $dataToUpdate['billing_address_country'],
            'billing_company_name' => $dataToUpdate['billing_company_name'],
            'billing_cif' => $dataToUpdate['billing_cif'],
            'billing_phone_number' => $dataToUpdate['billing_phone_number'],
        ]);

        $this->assertDatabaseMissing('carts', [
            'id' => $data['id'],
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
    public function update_a_nonexistent_cart_in_database()
    {
        $data = factory(\Omatech\LaravelOrders\Models\Cart::class)->make()->toArray();
        $updated = app()->make(Cart::class)->update(9999, $data);

        $this->assertFalse($updated);

        $this->assertDatabaseMissing('carts', [
            'id' => 9999,
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
}