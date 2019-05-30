<?php

namespace Omatech\LaravelOrders\Middleware;

use Omatech\LaravelOrders\Exceptions\Cart\SessionCartIdNotExistsException;

class ThrowErrorIfSessionCartIdNotExists
{
    /**
     * @param $request
     * @param \Closure $next
     * @return mixed
     * @throws \Throwable
     */
    public function handle($request, \Closure $next)
    {
        throw_if(!session()->exists('orders.current_cart.id'), new SessionCartIdNotExistsException());

        return $next($request);
    }
}