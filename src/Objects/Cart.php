<?php

namespace Omatech\LaravelOrders\Objects;

use Omatech\LaravelOrders\Contracts\Cart as CartInterface;
use Omatech\LaravelOrders\Contracts\DeliveryAddress;
use Omatech\LaravelOrders\Contracts\FindCart;
use Omatech\LaravelOrders\Contracts\Product;
use Omatech\LaravelOrders\Contracts\SaveCart;

class Cart implements CartInterface
{
    private $id;
    private $products = array();
    private $deliveryAddress;

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
    public function load(array $data): Cart
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

    public function toArray(): array
    {
        $unset = ['save'];
        $object = get_object_vars($this);

        foreach ($object as $key => $value){
            if(in_array($key, $unset)){
                unset($object[$key]);
            }elseif (is_object($value) && in_array('toArray', get_class_methods($value))){
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
        foreach ($this->products as &$currentProduct) {
            if ($currentProduct->getProductId() == $product->getId()) {
                $merge = false;
                $currentProduct->setQuantity($currentProduct->getQuantity() + $product->getRequestedQuantity());
                break;
            }
        }

        if ($merge)
            array_push($this->products, $product->toCartLine());
    }

    public function pop(Product $product): void
    {
        $productId = $product->getId();
        foreach ($this->products as $key => $currentProduct) {
            if ($currentProduct->getProductId() == $productId) {
                unset($this->products[$key]);
                break;
            }
        }
    }

    public function getProducts(): array
    {
        return $this->products();
    }

    public function products(): array
    {
        //TODO test
        return $this->products;
    }
}