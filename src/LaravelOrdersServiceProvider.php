<?php

namespace Omatech\LaravelOrders;

use Illuminate\Support\ServiceProvider;
use Omatech\LaravelOrders\Api\Order as OrderApi;
use Omatech\LaravelOrders\Contracts\BillingData as BillingDataInterface;
use Omatech\LaravelOrders\Contracts\Cart as CartInterface;
use Omatech\LaravelOrders\Contracts\CartLine as CartLineInterface;
use Omatech\LaravelOrders\Contracts\Customer as CustomerInterface;
use Omatech\LaravelOrders\Contracts\DeliveryAddress as DeliveryAddressInterface;
use Omatech\LaravelOrders\Contracts\FillableOrderAttributes as FillableOrderAttributesInterface;
use Omatech\LaravelOrders\Contracts\FindAllCarts as FindAllCartsInterface;
use Omatech\LaravelOrders\Contracts\FindAllCustomers as FindAllCustomersInterface;
use Omatech\LaravelOrders\Contracts\FindAllOrders as FindAllOrdersInterface;
use Omatech\LaravelOrders\Contracts\FindCart as FindCartInterface;
use Omatech\LaravelOrders\Contracts\FindCustomer as FindCustomerInterface;
use Omatech\LaravelOrders\Contracts\FindOrder as FindOrderInterface;
use Omatech\LaravelOrders\Contracts\FindProduct as FindProductInterface;
use Omatech\LaravelOrders\Contracts\Order as OrderInterface;
use Omatech\LaravelOrders\Contracts\OrderCode as OrderCodeInterface;
use Omatech\LaravelOrders\Contracts\OrderLine as OrderLineInterface;
use Omatech\LaravelOrders\Contracts\Product as ProductInterface;
use Omatech\LaravelOrders\Contracts\SaveCart as SaveCartInterface;
use Omatech\LaravelOrders\Contracts\SaveCustomer as SaveCustomerInterface;
use Omatech\LaravelOrders\Contracts\SaveOrder as SaveOrderInterface;
use Omatech\LaravelOrders\Contracts\SaveProduct as SaveProductInterface;
use Omatech\LaravelOrders\Middleware\ThrowErrorIfSessionCartIdNotExists;
use Omatech\LaravelOrders\Objects\BillingData;
use Omatech\LaravelOrders\Objects\Cart;
use Omatech\LaravelOrders\Objects\CartLine;
use Omatech\LaravelOrders\Objects\Customer;
use Omatech\LaravelOrders\Objects\DeliveryAddress;
use Omatech\LaravelOrders\Objects\FillableOrderAttributes;
use Omatech\LaravelOrders\Objects\Order;
use Omatech\LaravelOrders\Objects\OrderCode;
use Omatech\LaravelOrders\Objects\OrderLine;
use Omatech\LaravelOrders\Objects\Product;
use Omatech\LaravelOrders\Repositories\Cart\FindAllCarts;
use Omatech\LaravelOrders\Repositories\Cart\FindCart;
use Omatech\LaravelOrders\Repositories\Cart\SaveCartCart;
use Omatech\LaravelOrders\Repositories\Customer\FindAllCustomers;
use Omatech\LaravelOrders\Repositories\Customer\FindCustomer;
use Omatech\LaravelOrders\Repositories\Customer\SaveCustomer;
use Omatech\LaravelOrders\Repositories\Order\FindAllOrders;
use Omatech\LaravelOrders\Repositories\Order\FindOrder;
use Omatech\LaravelOrders\Repositories\Order\SaveOrder;
use Omatech\LaravelOrders\Repositories\Product\FindProduct;
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
        $this->app->bind(FillableOrderAttributesInterface::class, FillableOrderAttributes::class);
        $this->app->bind(FindAllCustomersInterface::class, FindAllCustomers::class);
        $this->app->bind(FindAllCartsInterface::class, FindAllCarts::class);
        $this->app->bind(FindAllOrdersInterface::class, FindAllOrders::class);
        $this->app->bind(FindCartInterface::class, FindCart::class);
        $this->app->bind(FindCustomerInterface::class, FindCustomer::class);
        $this->app->bind(FindOrderInterface::class, FindOrder::class);
        $this->app->bind(FindProductInterface::class, FindProduct::class);
        $this->app->bind(OrderInterface::class, Order::class);
        $this->app->bind(OrderCodeInterface::class, OrderCode::class);
        $this->app->bind(OrderLineInterface::class, OrderLine::class);
        $this->app->bind(ProductInterface::class, Product::class);
        $this->app->bind(SaveCartInterface::class, SaveCartCart::class);
        $this->app->bind(SaveCustomerInterface::class, SaveCustomer::class);
        $this->app->bind(SaveOrderInterface::class, SaveOrder::class);
        $this->app->bind(SaveProductInterface::class, SaveProduct::class);

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
                __DIR__ . '/../database/migrations/1000_create_products_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '1000_create_products_table.php'),
                __DIR__ . '/../database/migrations/2000_create_customers_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '2000_create_customers_table.php'),
                __DIR__ . '/../database/migrations/3000_create_orders_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '3000_create_orders_table.php'),
                __DIR__ . '/../database/migrations/5000_create_carts_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '5000_create_carts_table.php'),
            ], 'migrations');
        }

        $this->app['router']->aliasMiddleware('checkCartIdInSession', ThrowErrorIfSessionCartIdNotExists::class);

    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/orders.php', 'laravel-orders');

        $this->app->singleton('order', function () {
            return new OrderApi;
        });
    }
}
