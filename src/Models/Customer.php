<?php

namespace Omatech\LaravelOrders\Models;

use Illuminate\Database\Eloquent\Model;
use Omatech\LaravelOrders\Traits\ModelMacroable;

class Customer extends Model
{
    use ModelMacroable;

    protected $fillable = [
        'first_name',
        'last_name',
        'birthday',
        'phone_number',
        'gender',
    ];

    /**
     * Customer constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (config('laravel-orders.options.users.enabled') === true) {
            $this->fillable[] = 'user_id';
            $modelNamespace = config('laravel-orders.options.users.model');
            self::macro('user', function () use ($modelNamespace) {
                return $this->belongsTo($modelNamespace);
            });

        } elseif (self::hasMacro('user')) {
            unset(self::$macros['user']);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deliveryAddresses()
    {
        return $this->hasMany(DeliveryAddress::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function billingDatum()
    {
        return $this->hasMany(BillingData::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function billingData()
    {
        return $this->billingDatum();
    }

    /**
     * @return mixed
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}