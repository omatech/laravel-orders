<?php

namespace Omatech\LaravelOrders\Models;

use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{

    protected $fillable = [
        'order_id',
        'quantity',
    ];

    public function order()
    {
        $this->belongsTo(OrderLine::class);
    }

}