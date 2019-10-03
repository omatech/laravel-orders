<?php

namespace Omatech\LaravelOrders\Repositories\Product;

use Omatech\LaravelOrders\Contracts\FindProduct as FindProductInterface;
use Omatech\LaravelOrders\Contracts\Product;
use Omatech\LaravelOrders\Repositories\ProductRepository;

class FindProduct extends ProductRepository implements FindProductInterface
{
    /**
     * @var Product
     */
    private $product;

    /**
     * FindProduct constructor.
     *
     * @param Product $product
     * @throws \Exception
     */
    public function __construct(Product $product)
    {
        parent::__construct();
        $this->product = $product;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function make(int $id)
    {
        $product = $this->model->find($id);

        if (is_null($product)) {
            return null;
        }

        $this->product->load($product->toArray());
        return $this->product;
    }
}