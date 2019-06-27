<?php

namespace Omatech\LaravelOrders\Objects;

use Omatech\LaravelOrders\Contracts\Order as OrderInterface;

class Order implements OrderInterface
{
    private $id;
    private $customerId;

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
     * @deprecated
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


}