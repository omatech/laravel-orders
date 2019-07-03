<?php

namespace Omatech\LaravelOrders\Objects;

use Illuminate\Support\Str;
use Omatech\LaravelOrders\Contracts\BillingData;
use Omatech\LaravelOrders\Contracts\DeliveryAddress;
use Omatech\LaravelOrders\Contracts\FindOrder;
use Omatech\LaravelOrders\Contracts\Order as OrderInterface;
use Omatech\LaravelOrders\Contracts\OrderCode;
use Omatech\LaravelOrders\Contracts\OrderLine as Line;
use Omatech\LaravelOrders\Contracts\SaveOrder;

class Order implements OrderInterface
{
    private $id;
    private $customerId;
    private $code;
    private $lines = [];
    private $deliveryAddress;
    private $billingData;

    private $save;

    /**
     * Order constructor.
     * @param OrderCode $code
     * @param SaveOrder $save
     */
    public function __construct(OrderCode $code, SaveOrder $save)
    {
        $this->code = $code->get();
        $this->save = $save;
    }

    /**
     *
     */
    public function save(): void
    {
        $this->save->save($this);
    }

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

        if (key_exists('customer_id', $data))
            $this->setCustomerId($data['customer_id']);

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
            }else{
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

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getDeliveryAddress(): DeliveryAddress
    {
        return $this->deliveryAddress;
    }

    /**
     * @param mixed $deliveryAddress
     */
    public function setDeliveryAddress(DeliveryAddress $deliveryAddress): void
    {
        $this->deliveryAddress = $deliveryAddress;
    }

    /**
     * @return mixed
     */
    public function getBillingData(): BillingData
    {
        return $this->billingData;
    }

    /**
     * @param mixed $billingData
     */
    public function setBillingData(BillingData $billingData): void
    {
        $this->billingData = $billingData;
    }

}