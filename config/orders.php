<?php

return [
    'options' => [
        'users' => [
            'enabled' => false,
            'model' => 'App\User'
        ],
        'products' => [
            'model' => \Omatech\LaravelOrders\Models\Product::class,
            'enabled' => true
        ],
        'carts' => [
            'model' => \Omatech\LaravelOrders\Models\Cart::class,
        ],
        'customers' => [
            'model' => \Omatech\LaravelOrders\Models\Customer::class
        ],
        'orders' => [
            'model' => \Omatech\LaravelOrders\Models\Order::class
        ],
    ],
];