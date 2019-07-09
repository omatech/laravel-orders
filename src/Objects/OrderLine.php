<?php

namespace Omatech\LaravelOrders\Objects;

use Illuminate\Support\Str;
use Omatech\LaravelOrders\Contracts\OrderLine as OrderLineInterface;
use Omatech\LaravelOrders\Contracts\Product;

class OrderLine implements OrderLineInterface
{
    private $id;
    private $quantity;
    private $totalPrice;
    private $unitPrice;
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @param array $data
     * @return OrderLine
     */
    public function fromArray(array $data): self
    {
        if (key_exists('id', $data))
            $this->setId($data['id']);

        if (key_exists('quantity', $data))
            $this->setQuantity($data['quantity']);

        if (key_exists('unit_price', $data))
            $this->setUnitPrice($data['unit_price']);

        if (key_exists('total_price', $data))
            $this->setTotalPrice($data['total_price']);

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $unset = ['save'];
        $object = get_object_vars($this);

        $array = [];

        foreach ($object as $key => $value) {
            if (in_array($key, $unset)) {
                unset($object[$key]);
            } elseif (is_object($value) && in_array('toArray', get_class_methods($value))) {
                $array[Str::snake($key)] = $value->toArray();
            } else {
                $array[Str::snake($key)] = $value;
            }
        }

        return $array;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    /**
     * @param float $totalPrice
     * @return mixed
     */
    public function setTotalPrice(float $totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }

    /**
     * @return mixed
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * @param mixed $unitPrice
     */
    public function setUnitPrice(float $unitPrice): void
    {
        $this->unitPrice = $unitPrice;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return app(Product::class)->fromArray([
            'requestedQuantity' => $this->quantity,
            'unitPrice' => $this->unitPrice
        ]);
    }
}