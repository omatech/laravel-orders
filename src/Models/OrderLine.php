<?php

namespace Omatech\LaravelOrders\Models;

use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{

    public function order()
    {
        $this->belongsTo(OrderLine::class);
    }

}