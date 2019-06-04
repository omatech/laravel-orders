<?php

namespace Omatech\LaravelOrders;

//use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;
use Omatech\LaravelOrders\Contracts\Cart;
use Omatech\LaravelOrders\Contracts\FindCart;
use Omatech\LaravelOrders\Contracts\SaveCart;
use Omatech\LaravelOrders\Objects\Cart as CartInterface; //TODO canviar el nom de l'as
use Omatech\LaravelOrders\Objects\CartLine;
use Omatech\LaravelOrders\Objects\Customer;
use Omatech\LaravelOrders\Objects\Product;
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
        $this->app->bind(Cart::class, CartInterface::class);
        $this->app->bind(\Omatech\LaravelOrders\Contracts\Product::class, Product::class);
        $this->app->bind(\Omatech\LaravelOrders\Contracts\Customer::class, Customer::class);
        $this->app->bind(SaveCart::class, SaveCartCart::class);
        $this->app->bind(\Omatech\LaravelOrders\Contracts\SaveProduct::class, SaveProduct::class);
        $this->app->bind(\Omatech\LaravelOrders\Contracts\SaveCustomer::class, SaveCustomer::class);
        $this->app->bind(\Omatech\LaravelOrders\Contracts\CartLine::class, CartLine::class);
        $this->app->bind(FindCart::class, \Omatech\LaravelOrders\Repositories\Cart\FindCart::class);
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
                __DIR__ . '/../resources/views' => resource_path('views/vendor/orders'),
            ], 'views');

            // Publishing assets.
            $this->publishes([
                __DIR__.'/../database/migrations/1000_create_products_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'1000_create_products_table.php'),
                __DIR__.'/../database/migrations/2000_create_customers_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'2000_create_customers_table.php'),
                __DIR__.'/../database/migrations/2500_create_customer_delivery_addresses_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'2500_create_customer_delivery_addresses_table.php'),
                __DIR__.'/../database/migrations/3000_create_orders_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'3000_create_orders_table.php'),
                __DIR__.'/../database/migrations/4000_create_order_lines_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'4000_create_order_lines_table.php'),
                __DIR__.'/../database/migrations/5000_create_carts_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'5000_create_carts_table.php'),
                __DIR__.'/../database/migrations/6000_create_cart_lines_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'6000_create_cart_lines_table.php'),
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
