<?php

namespace Omatech\LaravelOrders\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'id'
    ];

    public function cartLines()
    {
        return $this->hasMany(CartLine::class);
    }
}