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
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-orders');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-orders');
//        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations'); //TODO les hauríem de publicar enlloc de carregar
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/orders.php' => config_path('orders.php'),
            ], 'config');

            // Publishing the views.
            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/laravel-orders'),
            ], 'views');

            // Publishing assets.
            $this->publishes([
                __DIR__ . '/../database/migrations/1000_create_products_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '1000_create_products_table.php'),
                __DIR__ . '/../database/migrations/2000_create_customers_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '2000_create_customers_table.php'),
                __DIR__ . '/../database/migrations/2500_create_customer_delivery_addresses_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '2500_create_customer_delivery_addresses_table.php'),
                __DIR__ . '/../database/migrations/3000_create_orders_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '3000_create_orders_table.php'),
                __DIR__ . '/../database/migrations/4000_create_order_lines_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '4000_create_order_lines_table.php'),
                __DIR__ . '/../database/migrations/5000_create_carts_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '5000_create_carts_table.php'),
                __DIR__ . '/../database/migrations/6000_create_cart_lines_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '6000_create_cart_lines_table.php'),
            ], 'migrations');

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-orders'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-orders'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }

    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/orders.php', 'laravel-orders');

        // Register the main class to use with the facade
//        $this->app->singleton('order', function () {
//            return new LaravelOrders;
//        });
//        $this->app->bind('order', function (){
//            return new Order();
//        });
    }
}
