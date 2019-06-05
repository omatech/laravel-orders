<?php

namespace Omatech\LaravelOrders\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    protected $table = 'customer_delivery_addresses';
    protected $fillable = [
        'customer_id',
        'first_name',
        'last_name',
        'first_line',
        'second_line',
        'postal_code',
        'city',
        'region',
        'country',
        'is_a_company',
        'company_name',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}