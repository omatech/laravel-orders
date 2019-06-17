<?php

namespace Omatech\LaravelOrders\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Omatech\LaravelOrders\Rules\IsABillingDataObject;

class AssignABillingDataToCart extends FormRequest
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
            'billing_data' => ['required', new IsABillingDataObject],
        ];
    }
}