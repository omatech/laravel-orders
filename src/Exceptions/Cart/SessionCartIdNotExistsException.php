<?php
/**
 * Company: Omatech
 * User: aroca@omatech.com
 * Creation date: 27/05/19
 */

namespace Omatech\LaravelOrders\Exceptions\Cart;


use Omatech\LaravelOrders\Exceptions\BaseException;

class SessionCartIdNotExistsException extends BaseException
{
    /**
     * SessionCartIdNotExistsException constructor.
     */
    public function __construct()
    {
        parent::__construct('The cart is empty.');
    }
}