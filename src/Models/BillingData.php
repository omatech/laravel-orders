<?php

namespace Omatech\LaravelOrders\Models;


use Illuminate\Database\Eloquent\Model;

class BillingData extends Model
{
    protected $table = 'customer_billing_data';
    protected $fillable = [
        'customer_id',
        'address_first_name',
        'address_last_name',
        'address_first_line',
        'address_second_line',
        'address_postal_code',
        'address_city',
        'address_region',
        'address_country',
        'company_name',
        'cif',
        'phone_number',
    ];
}