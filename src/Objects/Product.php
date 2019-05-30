<?php

namespace Omatech\LaravelOrders\Objects;

use Omatech\LaravelOrders\Contracts\SaveProduct;

class Product implements \Omatech\LaravelOrders\Contracts\Product
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

    public function toCartLine(): \Omatech\LaravelOrders\Contracts\CartLine
    {
        return app(\Omatech\LaravelOrders\Contracts\CartLine::class)->load([
            'product_id' => $this->id,
            'quantity' => $this->requestedQuantity
        ]);
    }

}