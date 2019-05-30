<?php

namespace Omatech\LaravelOrders\Rules;


use Illuminate\Contracts\Validation\Rule;
use Omatech\LaravelOrders\Contracts\Product;

class RequestedProductQuantityIsNotZero implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return is_a($value, Product::class)
            && !is_null($value->getRequestedQuantity())
            && is_numeric($value->getRequestedQuantity())
            && $value->getRequestedQuantity() !== 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return 'Incorrect requested quantity';
    }
}