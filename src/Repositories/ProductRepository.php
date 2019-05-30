<?php
/**
 * Company: Omatech
 * User: aroca@omatech.com
 * Creation date: 28/05/19
 */

namespace Omatech\LaravelOrders\Repositories;


use Omatech\LaravelOrders\Models\Product;

class ProductRepository extends BaseRepository
{

    /**
     * @return mixed
     */
    public function model()
    {
        return Product::class;
    }
}