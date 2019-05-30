<?php

namespace Omatech\LaravelOrders;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Omatech\LaravelOrders\Skeleton\SkeletonClass
 */
class LaravelOrdersFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'order';
    }
}
