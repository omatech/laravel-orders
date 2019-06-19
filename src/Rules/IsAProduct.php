<?php

namespace Omatech\LaravelOrders\Rules;

use Illuminate\Contracts\Validation\Rule;
use Omatech\LaravelOrders\Contracts\Product;

class IsAProduct implements Rule
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
        return is_a($value, Product::class);
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return 'Incorrect Product';
    }
}