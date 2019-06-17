<?php

namespace Omatech\LaravelOrders\Tests;

use Omatech\LaravelOrders\LaravelOrdersServiceProvider;
use Orchestra\Testbench\TestCase;

class BaseTestCase extends TestCase
{

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    public function getPackageProviders($app)
    {
        return [
            LaravelOrdersServiceProvider::class
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    public function getEnvironmentSetUp($app)
    {
        include_once __DIR__ . '/../database/migrations/1000_create_products_table.php.stub';
        include_once __DIR__ . '/../database/migrations/2000_create_customers_table.php.stub';
        include_once __DIR__ . '/../database/migrations/3000_create_orders_table.php.stub';
        include_once __DIR__ . '/../database/migrations/5000_create_carts_table.php.stub';

        (new \CreateProductsTable())->up();
        (new \CreateCustomersTable())->up();
        (new \CreateOrdersTable())->up();
        (new \CreateCartsTable())->up();
    }
}