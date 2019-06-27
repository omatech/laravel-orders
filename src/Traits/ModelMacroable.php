<?php

/**
 * Macroable Trait specific for Eloquent Models
 */

namespace Omatech\LaravelOrders\Traits;

use Closure;
use Spatie\Macroable\Macroable;

trait ModelMacroable
{
    use Macroable;

    public static function __callStatic($method, $parameters)
    {
        if (!static::hasMacro($method)) {
            return parent::__callStatic($method, $parameters);
        }

        if (static::$macros[$method] instanceof Closure) {
            return call_user_func_array(Closure::bind(static::$macros[$method], null, static::class), $parameters);
        }

        return call_user_func_array(static::$macros[$method], $parameters);
    }

    public function __call($method, $parameters)
    {
        if (!static::hasMacro($method)) {
            return parent::__call($method, $parameters);
        }

        $macro = static::$macros[$method];

        if ($macro instanceof Closure) {
            return call_user_func_array($macro->bindTo($this, static::class), $parameters);
        }

        return call_user_func_array($macro, $parameters);
    }
}