<?php

namespace Omatech\LaravelOrders\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Omatech\LaravelOrders\Rules\IsAnExistingProduct;
use Omatech\LaravelOrders\Rules\RequestedProductQuantityIsNotZero;

class AddProductToCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product' => ['required', new IsAnExistingProduct, new RequestedProductQuantityIsNotZero],
        ];
    }
}