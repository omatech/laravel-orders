<?php

use Faker\Generator as Faker;

$factory->define(\Omatech\LaravelOrders\Models\Order::class, function (Faker $faker) {
    return [
        'customer_id' => factory(\Omatech\LaravelOrders\Models\Customer::class)->create()->id,
    ];
});