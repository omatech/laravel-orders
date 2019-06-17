<?php

namespace Omatech\LaravelOrders;

use Illuminate\Support\ServiceProvider;
use Omatech\LaravelOrders\Contracts\BillingData as BillingDataInterface;
use Omatech\LaravelOrders\Contracts\Cart as CartInterface;
use Omatech\LaravelOrders\Contracts\CartLine as CartLineInterface;
use Omatech\LaravelOrders\Contracts\Customer as CustomerInterface;
use Omatech\LaravelOrders\Contracts\DeliveryAddress as DeliveryAddressInterface;
use Omatech\LaravelOrders\Contracts\FindCart as FindCartInterface;
use Omatech\LaravelOrders\Contracts\Product as ProductInterface;
use Omatech\LaravelOrders\Contracts\SaveCart as SaveCartInterface;
use Omatech\LaravelOrders\Contracts\SaveCustomer as SaveCustomerInterface;
use Omatech\LaravelOrders\Contracts\SaveProduct as SaveProductInterface;
use Omatech\LaravelOrders\Objects\BillingData;
use Omatech\LaravelOrders\Objects\Cart;
use Omatech\LaravelOrders\Objects\CartLine;
use Omatech\LaravelOrders\Objects\Customer;
use Omatech\LaravelOrders\Objects\DeliveryAddress;
use Omatech\LaravelOrders\Objects\Product;
use Omatech\LaravelOrders\Repositories\Cart\FindCart;
use Omatech\LaravelOrders\Repositories\Cart\SaveCartCart;
use Omatech\LaravelOrders\Repositories\Customer\SaveCustomer;
use Omatech\LaravelOrders\Repositories\Product\SaveProduct;

class LaravelOrdersServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->bind(BillingDataInterface::class, BillingData::class);
        $this->app->bind(CartInterface::class, Cart::class);
        $this->app->bind(CartLineInterface::class, CartLine::class);
        $this->app->bind(CustomerInterface::class, Customer::class);
        $this->app->bind(DeliveryAddressInterface::class, DeliveryAddress::class);
        $this->app->bind(FindCartInterface::class, FindCart::class);
        $this->app->bind(ProductInterface::class, Product::class);
        $this->app->bind(SaveCartInterface::class, SaveCartCart::class);
        $this->app->bind(SaveCustomerInterface::class, SaveCustomer::class);
        $this->app->bind(SaveProductInterface::class, SaveProduct::class);

        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-orders');

        if ($this->app->runningInConsole()) {
            // Publishing the config file.
            $this->publishes([
                __DIR__ . '/../config/orders.php' => config_path('orders.php'),
            ], 'config');

            // Publishing the views.
            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/laravel-orders'),
            ], 'views');

            // Publishing assets.
            $this->publishes([
                __DIR__ . '/../database/migrations/1000_create_products_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_1000_create_products_table.php'),
                __DIR__ . '/../database/migrations/2000_create_customers_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_2000_create_customers_table.php'),
                __DIR__ . '/../database/migrations/3000_create_orders_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_3000_create_orders_table.php'),
                __DIR__ . '/../database/migrations/5000_create_carts_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_5000_create_carts_table.php'),
            ], 'migrations');
        }

    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/orders.php', 'laravel-orders');
    }
}
