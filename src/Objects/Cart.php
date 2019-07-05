<?php

namespace Omatech\LaravelOrders\Objects;

use Omatech\LaravelOrders\Contracts\BillingData;
use Omatech\LaravelOrders\Contracts\Cart as CartInterface;
use Omatech\LaravelOrders\Contracts\DeliveryAddress;
use Omatech\LaravelOrders\Contracts\FindCart;
use Omatech\LaravelOrders\Contracts\Order;
use Omatech\LaravelOrders\Contracts\Product;
use Omatech\LaravelOrders\Contracts\SaveCart;

class Cart implements CartInterface
{
    private $id;
    private $cartLines = [];
    private $deliveryAddress;
    private $billingData;
    private $totalPrice;
    private $numCartLines = 0;

    private $save;

    public function __construct(SaveCart $save)
    {
        $this->save = $save;
    }

    /**
     * @param int $id
     * @return Cart
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    static public function find(int $id): ?Cart
    {
        $find = app()->make(FindCart::class);
        return $find->make($id);
    }

    /**
     * @param array $data
     * @return $this
     */
    public function fromArray(array $data): Cart
    {
        if (key_exists('id', $data))
            $this->setId($data['id']);

        return $this;
    }

    /**
     * @param array $data
     * @return $this
     * @deprecated
     */
    public function load(array $data): Cart
    {
        return $this->fromArray($data);
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

    /**
     * @param DeliveryAddress $deliveryAddress
     */
    public function setDeliveryAddress(DeliveryAddress $deliveryAddress)
    {
        $this->deliveryAddress = $deliveryAddress;
    }

    /**
     * @return DeliveryAddress
     */
    public function getDeliveryAddress(): DeliveryAddress
    {
        return $this->deliveryAddress;
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

    /**
     * @return mixed
     */
    public function getTotalPrice()
    {
        $cartLines = $this->getCartLines();
        $totalPrice = 0;

        foreach ($cartLines as $cartLine) {
            $totalPrice += $cartLine->getQuantity() * optional($cartLine->getProduct())->getUnitPrice();
        }

        $this->totalPrice = $totalPrice;

        return $this->totalPrice;
    }

    /**
     * @return int
     */
    public function getNumCartLines(): int
    {
        $this->numCartLines = count($this->getCartLines());

        return $this->numCartLines;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $unset = ['save'];
        $object = get_object_vars($this);

        foreach ($object as $key => $value) {
            if (in_array($key, $unset)) {
                unset($object[$key]);
            } elseif (is_object($value) && in_array('toArray', get_class_methods($value))) {
                $object[$key] = $value->toArray();
            }
        }

        return $object;
    }

    public function save(): void
    {
        $this->save->save($this);
    }

    public function push(Product $product): void
    {
        $merge = true;
        foreach ($this->cartLines as &$currentProduct) {
            if ($currentProduct->getProductId() == $product->getId()) {
                $merge = false;
                $currentProduct->setQuantity($currentProduct->getQuantity() + $product->getRequestedQuantity());
                break;
            }
        }

        if ($merge)
            array_push($this->cartLines, $product->toCartLine());
    }

    public function pop(Product $product): void
    {
        $productId = $product->getId();
        foreach ($this->cartLines as $key => $currentProduct) {
            if ($currentProduct->getProductId() == $productId) {
                unset($this->cartLines[$key]);
                break;
            }
        }
    }

    public function getCartLines(): array
    {
        return $this->cartLines;
    }

    /**
     * @return Order
     */
    public function toOrder(): Order
    {
        $unset = ['id'];
        $data = $this->toArray();

        foreach ($unset as $key) {
            if (isset($data[$key])) {
                unset($data[$key]);
            }
        }

        if (isset($data['deliveryAddress'])) {
            foreach ($data['deliveryAddress'] as $deliveryAddressDatumKey => $deliveryAddressDatumValue) {
                $data['delivery_address_' . $deliveryAddressDatumKey] = $deliveryAddressDatumValue;
            }
            unset($data['deliveryAddress']);
        }
        if (isset($data['billingData'])) {
            foreach ($data['billingData'] as $billingDataDatumKey => $billingDataDatumValue) {
                $data['billing_' . $billingDataDatumKey] = $billingDataDatumValue;
            }
            unset($data['billingData']);
        }

        return app(Order::class)->fromArray($data);
    }
}