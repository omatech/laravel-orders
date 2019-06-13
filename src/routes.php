<?php

Route::namespace('Omatech\LaravelOrders\Controllers')
    ->prefix('orders/checkout')
    ->name('orders.checkout.')
    ->group(function ($route) {

        $route->get('basket', 'CheckoutController@basket')->name('basket');
        $route->get('delivery', 'CheckoutController@delivery')->name('delivery');
        $route->get('payment', 'CheckoutController@payment')->name('payment');
        $route->get('summary', 'CheckoutController@summary')->name('summary');
    });

Route::namespace('Omatech\LaravelOrders\Controllers')
    ->prefix('orders/cart')
    ->name('orders.cart.')
    ->group(function ($route) {

        $route->post('add-product', 'CartController@addProduct')->name('addProduct');
        $route->post('assign-delivery-address', 'CartController@assignDeliveryAddress')->name('assignDeliveryAddress');
    });