<?php

namespace Omatech\LaravelOrders;

//use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;
use Omatech\LaravelOrders\Contracts\Cart;
use Omatech\LaravelOrders\Contracts\SaveCart;
use Omatech\LaravelOrders\Objects\Cart as CartInterface; //TODO canviar el nom de l'as
use Omatech\LaravelOrders\Objects\CartLine;
use Omatech\LaravelOrders\Objects\Product;
use Omatech\LaravelOrders\Repositories\Cart\SaveCartCart;
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
        $this->app->bind(SaveCart::class, SaveCartCart::class);
        $this->app->bind(\Omatech\LaravelOrders\Contracts\SaveProduct::class, SaveProduct::class);
        $this->app->bind(\Omatech\LaravelOrders\Contracts\CartLine::class, CartLine::class);
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-orders');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-orders');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations'); //TODO les hauríem de publicar enlloc de carregar
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('orders.php'),
            ], 'config');

            // Publishing the views.
            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/orders'),
            ], 'views');

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
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'laravel-orders');

        // Register the main class to use with the facade
//        $this->app->singleton('order', function () {
//            return new LaravelOrders;
//        });
//        $this->app->bind('order', function (){
//            return new Order();
//        });
    }
}
