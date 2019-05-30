<?php

namespace Omatech\LaravelOrders\Repositories\Product;

use Omatech\LaravelOrders\Contracts\Product;
use Omatech\LaravelOrders\Repositories\ProductRepository;

class SaveProduct extends ProductRepository implements \Omatech\LaravelOrders\Contracts\SaveProduct
{

    /**
     * @param Product $product
     */
    public function save(Product &$product)
    {
        $model = $this->model;

        if (!is_null($product->getId())) {
            $model = $model->find($product->getId());
        }

        $model->fill($product->toArray());

        $model->saveOrFail();

        $product->setId($model->id);
    }
}