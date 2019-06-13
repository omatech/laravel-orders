<?php

namespace Omatech\LaravelOrders\Objects;

use Omatech\LaravelOrders\Contracts\CartLine;
use Omatech\LaravelOrders\Contracts\Product as ProductInterface;
use Omatech\LaravelOrders\Contracts\SaveProduct;

class Product implements ProductInterface
{
    private $id;
    private $requestedQuantity = 0;

    private $save;

    public function __construct(SaveProduct $save)
    {
        $this->save = $save;
    }

    static public function find(int $id): Product
    {
        //TODO
    }

    /**
     * @return int
     */
    public function getRequestedQuantity(): int
    {
        return $this->requestedQuantity;
    }

    /**
     * @param int $requestedQuantity
     */
    public function setRequestedQuantity(int $requestedQuantity): void
    {
        $this->requestedQuantity = $requestedQuantity;
    }

    /**
     * @param array $data
     * @return Product
     */
    public function load(array $data): Product
    {
        if (key_exists('id', $data))
            $this->setId($data['id']);

        if (key_exists('requestedQuantity', $data))
            $this->setRequestedQuantity($data['requestedQuantity']);

        return $this;
    }

    /**
     * @param $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function toArray(): array
    {
        $unset = ['save'];
        $object = get_object_vars($this);

        foreach ($unset as $value){
            unset($object[$value]);
        }

        return $object;
    }

    public function save(): void
    {
        $this->save->save($this);
    }

    /**
     * @return CartLine
     */
    public function toCartLine(): CartLine
    {
        return app(CartLine::class)->load([
            'product_id' => $this->id,
            'quantity' => $this->requestedQuantity
        ]);
    }

}