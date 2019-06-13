<?php

namespace Omatech\LaravelOrders\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Omatech\LaravelOrders\Rules\IsADeliveryAddressObject;

class AssignADeliveryAddressToCart extends FormRequest
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
            'delivery_address' => ['required', new IsADeliveryAddressObject],
        ];
    }
}