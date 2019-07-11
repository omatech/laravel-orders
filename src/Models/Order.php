<?php

namespace Omatech\LaravelOrders\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'customer_id',
        'code',
        'total_price',
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
        'delivery_address_email',
        'delivery_address_phone_number',
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderLines()
    {
        return $this->hasMany(OrderLine::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}