<?php
/**
 * Company: Omatech
 * User: aroca@omatech.com
 * Creation date: 03/06/19
 */

namespace Omatech\LaravelOrders\Contracts;


interface Customer
{
    public function load(array $data);
}