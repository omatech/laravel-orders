<?php

namespace Omatech\LaravelOrders\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['id', 'unit_price'];
}