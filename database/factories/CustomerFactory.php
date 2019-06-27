<?php

use Faker\Generator as Faker;

$factory->define(\Omatech\LaravelOrders\Models\Customer::class, function (Faker $faker) {
    return [
        'first_name' => 'Test Name',
    ];
});