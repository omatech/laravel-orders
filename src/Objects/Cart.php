<?php

namespace Omatech\LaravelOrders\Objects;

use Illuminate\Support\Str;
use Omatech\LaravelOrders\Contracts\BillingData;
use Omatech\LaravelOrders\Contracts\Cart as CartInterface;
use Omatech\LaravelOrders\Contracts\DeliveryAddress;
use Omatech\LaravelOrders\Contracts\FindAllCarts;
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
    public static function find(int $id): ?Cart
    {
        $find = app()->make(FindCart::class);
        return $find->make($id);
    }

    /**
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function findAll(): array
    {
        $find = app()->make(FindAllCarts::class);
        return $find->make();
    }

    /**
     * @param array $data
     * @return $this
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function fromArray(array $data): Cart
    {
//        if (key_exists('id', $data))
//            $this->setId($data['id']);

        $notSettableFromArray = [];
        $fillable = [
            'id',
            'delivery_address_first_name',
            'delivery_address_last_name',
            'delivery_address_first_line',
            'delivery_address_second_line',
            'delivery_address_postal_code',
            'delivery_address_city',
            'delivery_address_region',
            'delivery_address_country',
            'delivery_address_is_a_company',
            'delivery_address_company_name',
            'delivery_address_email',
            'delivery_address_phone_number',
            'billing_address_first_name',
            'billing_address_last_name',
            'billing_address_first_line',
            'billing_address_second_line',
            'billing_address_postal_code',
            'billing_address_city',
            'billing_address_region',
            'billing_address_country',
            'billing_company_name',
            'billing_cif',
            'billing_phone_number',
        ];

        $deliveryAddress = $billingData = [];
        foreach ($fillable as $field) {
            $key = null;
            $camelField = Str::camel($field);
            $snakeField = Str::snake($field);
            $setter = 'set' . $camelField;

            if (in_array($snakeField, $notSettableFromArray)) {
                continue;
            }

            if (key_exists($field, $data)) {
                $value = $data[$field];
            } elseif (key_exists($camelField, $data)) {
                $value = $data[$camelField];
            } elseif (key_exists($snakeField, $data)) {
                $value = $data[$snakeField];
            } else {
                continue;
            }

            if (method_exists($this, $setter)) {
                $this->{$setter}($value);
            } elseif (strpos($snakeField, 'delivery_address_') !== false) {
                $deliveryAddress[str_replace("delivery_address_", "", $snakeField)] = $value;
            } elseif (strpos($snakeField, 'billing_') !== false) {
                $billingData[str_replace("billing_", "", $snakeField)] = $value;
            }
        }

        if ($billingData) {
            $this->setBillingData(app()->make(BillingData::class)->fromArray($billingData));
        }

        if ($deliveryAddress) {
            $this->setDeliveryAddress(app()->make(DeliveryAddress::class)->fromArray($deliveryAddress));
        }

        return $this;
    }

    /**
     * @param array $data
     * @return $this
     * @deprecated fromArray should be used directly instead. Will be removed in future versions.
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
    public function getTotalPrice(): float
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
            } elseif ($key === 'cartLines' && is_array($value)) {
                foreach ($value as $lineKey => $lineValue) {
                    if (is_object($lineValue) && in_array('toArray', get_class_methods($lineValue))) {
                        $object[$key][$lineKey] = $lineValue->toArray();
                    }
                }
            }
        }

        return $object;
    }

    public function save(): void
    {
        $this->save->save($this);
    }

    public function removeProduct(Product $product)
    {
        foreach ($this->cartLines as $index => &$currentProduct) {
            if ($currentProduct->getProductId() == $product->getId()) {
                $currentProduct->setQuantity($currentProduct->getQuantity() * -1);
                break;
            }
        }
    }

    public function setProductQuantity(Product $product)
    {
        foreach ($this->cartLines as &$currentProduct) {
            if ($currentProduct->getProductId() == $product->getId()) {
                $currentProduct->setQuantity($product->getRequestedQuantity());
                break;
            }
        }
    }

    public function push(Product $product): void
    {
        $merge = true;
        
        foreach ($this->cartLines as &$currentProduct) {
            if ($currentProduct->getProductId() == $product->getId()) {

                $totalQuantity = $currentProduct->getQuantity() + $product->getRequestedQuantity();
                $currentProduct->setQuantity($totalQuantity);
                
                $merge = false;
                break;
            }
        }

        if ($merge) {
            array_push($this->cartLines, $product->toCartLine());
        }
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
        $orderTotalPrice = 0;

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

        if (isset($data['cartLines']) && is_array($data['cartLines'])) {
            $data['lines'] = $data['cartLines'];
            unset($data['cartLines']);

            foreach ($data['lines'] as &$line) {
                $lineTotalPrice = 0;
                if (!empty($line['product_id'])) {
                    $currentLineProduct = app(Product::class)->find($line['product_id']);
                    $currentLineProduct->setRequestedQuantity($line['quantity']);
                    $lineTotalPrice = $currentLineProduct->getUnitPrice() * $line['quantity'];
                    $orderTotalPrice += $lineTotalPrice;

                    $line = array_merge($line, [
                        'total_price' => $lineTotalPrice,
                        'unit_price' => $currentLineProduct->getUnitPrice(),
                        'product' => $currentLineProduct->toArray(),
                        'product_id' => $currentLineProduct->getId(),
                        'external_id' => $currentLineProduct->getExternalId()
                    ]);
                }
            }
        }

        $data['totalPrice'] = $orderTotalPrice;

        return app(Order::class)->fromArray($data);
    }
}
