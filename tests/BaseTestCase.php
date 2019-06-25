<?php

namespace Omatech\LaravelOrders\Tests;

use Illuminate\Support\Facades\Config;
use Omatech\LaravelOrders\LaravelOrdersServiceProvider;
use Orchestra\Testbench\TestCase;

class BaseTestCase extends TestCase
{

    /**
     * Array with the name of the tests that need
     * to activate the option laravel-orders.options.users.enabled
     *
     * @var array
     */
    protected $enableUsersTests = [];

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
        if (in_array($this->getName(), $this->enableUsersTests)) {
            Config::set('laravel-orders.options.users.enabled', true);
        }

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