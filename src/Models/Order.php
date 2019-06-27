<?php
/**
 * Created by Omatech
 * User: aroca@omatech.com
 * Date: 23/08/18 18:01
 */
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
//        'code',
//        'status'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderLines()
    {
        return $this->hasMany(OrderLine::class);
    }

    /**
     *
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}