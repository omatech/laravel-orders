<?php

namespace Omatech\LaravelOrders\Tests;


use Omatech\LaravelOrders\LaravelOrdersServiceProvider;

class BaseTestCase extends \Orchestra\Testbench\TestCase
{

    public function getPackageProviders($app)
    {
        return [
            LaravelOrdersServiceProvider::class
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        include_once __DIR__.'/../database/migrations/1000_create_products_table.php.stub';
        include_once __DIR__.'/../database/migrations/2000_create_customers_table.php.stub';
        include_once __DIR__.'/../database/migrations/2500_create_customer_delivery_addresses_table.php.stub';
        include_once __DIR__.'/../database/migrations/3000_create_orders_table.php.stub';
        include_once __DIR__.'/../database/migrations/4000_create_order_lines_table.php.stub';
        include_once __DIR__.'/../database/migrations/5000_create_carts_table.php.stub';
        include_once __DIR__.'/../database/migrations/6000_create_cart_lines_table.php.stub';

        (new \CreateProductsTable())->up();
        (new \CreateCustomersTable())->up();
        (new \CreateCustomerDeliveryAddressesTable())->up();
        (new \CreateOrdersTable())->up();
        (new \CreateOrderLinesTable())->up();
        (new \CreateCartsTable())->up();
        (new \CreateCartLinesTable())->up();
    }
}