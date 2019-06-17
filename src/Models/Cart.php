<?php

namespace Omatech\LaravelOrders\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'id',
        'delivery_address_first_name',
        'delivery_address_last_name',
        'delivery_address_first_line',
        'delivery_address_second_line',
        'delivery_address_postal_code',
        'delivery_address_city',
        'delivery_address_region',
        'delivery_address_country',
        'delivery_address_is_a_company',
        'delivery_address_company_name',
        'billing_address_first_name',
        'billing_address_last_name',
        'billing_address_first_line',
        'billing_address_second_line',
        'billing_address_postal_code',
        'billing_address_city',
        'billing_address_region',
        'billing_address_country',
        'billing_company_name',
        'billing_cif',
        'billing_phone_number',
    ];

    public function cartLines()
    {
        return $this->hasMany(CartLine::class);
    }
}