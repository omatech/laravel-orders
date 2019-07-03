<?php

use Faker\Generator as Faker;

$factory->define(\Omatech\LaravelOrders\Models\Order::class, function (Faker $faker) {

    $deliveryAddressIsACompany = $faker->boolean();

    return [
        'customer_id' => factory(\Omatech\LaravelOrders\Models\Customer::class)->create()->id,

        'code' => $faker->randomNumber(8),

        'delivery_address_first_name' => $faker->firstName,
        'delivery_address_last_name' => $faker->lastName,
        'delivery_address_first_line' => $faker->streetAddress,
        'delivery_address_second_line' => $faker->randomNumber() . ', '. $faker->randomNumber(),
        'delivery_address_postal_code' => $faker->postcode,
        'delivery_address_city' => $faker->city,
        'delivery_address_region' => $faker->city,
        'delivery_address_country' => $faker->country,
        'delivery_address_is_a_company' => $deliveryAddressIsACompany,
        'delivery_address_company_name' => $deliveryAddressIsACompany ? $faker->company : null,
        'delivery_address_email' => $faker->email,
        'delivery_address_phone_number' => $faker->phoneNumber,

        'billing_address_first_name' => $faker->firstName,
        'billing_address_last_name' => $faker->lastName,
        'billing_address_first_line' => $faker->streetAddress,
        'billing_address_second_line' => $faker->randomNumber() . ', '. $faker->randomNumber(),
        'billing_address_postal_code' => $faker->postcode,
        'billing_address_city' => $faker->city,
        'billing_address_region' => $faker->city,
        'billing_address_country' => $faker->country,
        'billing_company_name' => $faker->company,
        'billing_cif' => $faker->randomNumber(8),
        'billing_phone_number' => $faker->phoneNumber,
    ];
});