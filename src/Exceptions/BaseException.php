<?php

namespace Omatech\LaravelOrders\Exceptions;

use Exception;

class BaseException extends Exception
{
    /**
     * BaseException constructor.
     *
     * @param $message
     * @param $code
     */
    public function __construct($message = 'Error', $code = 500)
    {
        parent::__construct();

        $this->message = $message;
        $this->code = $code;
    }

    /**
     * @return $this
     */
    public function render()
    {
        return response()->json($this->message)->setStatusCode($this->code);
    }
}