<?php

use Faker\Generator as Faker;

$factory->define(\Omatech\LaravelOrders\Models\OrderLine::class, function (Faker $faker) {
    return [
        'order_id' => factory(\Omatech\LaravelOrders\Models\Order::class)->create()->id,
        'quantity' => $faker->randomNumber(1),
    ];
});