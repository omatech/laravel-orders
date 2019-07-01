<?php

namespace Omatech\LaravelOrders\Objects;

use Omatech\LaravelOrders\Contracts\FindOrder;
use Omatech\LaravelOrders\Contracts\Order as OrderInterface;
use Omatech\LaravelOrders\Contracts\OrderLine as Line;

class Order implements OrderInterface
{
    private $id;
    private $customerId;
    private $lines = [];

    /**
     * @param int $id
     * @return null|Order
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    static public function find(int $id): ?self
    {
        $find = app()->make(FindOrder::class);
        return $find->make($id);
    }

    /**
     * @param array $data
     * @return Order
     */
    public function fromArray(array $data): self
    {
        if (key_exists('id', $data))
            $this->setId($data['id']);

        if (key_exists('customerId', $data))
            $this->setCustomerId($data['customerId']);

        return $this;
    }

    /**
     * @param array $data
     * @return $this
     * @deprecated fromArray should be used directly instead. Will be removed in future versions.
     */
    public function load(array $data): self
    {
        return $this->fromArray($data);
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
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param mixed $customerId
     */
    public function setCustomerId($customerId): void
    {
        $this->customerId = $customerId;
    }

    /**
     * @return array
     */
    public function getLines(): array
    {
        return $this->lines;
    }

    /**
     * @param Line $line
     */
    public function pushLine(Line $line): void
    {
        array_push($this->lines, $line);
    }


}