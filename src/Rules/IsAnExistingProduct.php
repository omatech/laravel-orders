<?php

namespace Omatech\LaravelOrders\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Omatech\LaravelOrders\Contracts\Product;

class IsAnExistingProduct implements Rule
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
            && !is_null($value->getId())
            && Validator::make([
                'id' => $value->getId()
            ], [
                'id' => 'exists:products,id'
            ])->passes();
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return 'Incorrect product or does not exist';
    }
}