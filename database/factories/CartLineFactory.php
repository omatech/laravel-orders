<?php

use Faker\Generator as Faker;

$factory->define(\Omatech\LaravelOrders\Models\CartLine::class, function (Faker $faker) {
    return [
        'cart_id' => factory(\Omatech\LaravelOrders\Models\Cart::class)->create()->id,
        'product_id' => factory(\Omatech\LaravelOrders\Models\Product::class)->create()->id,
        'quantity' => $faker->randomNumber(1),
    ];
});