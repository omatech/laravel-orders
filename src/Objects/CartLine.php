<?php

namespace Omatech\LaravelOrders\Objects;


//use Omatech\LaravelOrders\Contracts\SaveCart;

class CartLine implements \Omatech\LaravelOrders\Contracts\CartLine
{
    private $id;
    private $product_id;
    private $cart_id;
    private $quantity = 0;

//    private $save;

//    public function __construct(SaveCart $save)
//    {
//        $this->save = $save;
//    }

    /**
     * @param int $id
     * @return CartLine
     */
    static public function find(int $id): CartLine
    {
        //TODO
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getCartId()
    {
        return $this->cart_id;
    }

    /**
     * @param mixed $cart_id
     */
    public function setCartId($cart_id): void
    {
        $this->cart_id = $cart_id;
    }

    /**
     * @return mixed
     */
    public function getProductId(): ?int
    {
        return $this->product_id;
    }

    /**
     * @param mixed $product_id
     */
    public function setProductId(int $product_id): void
    {
        $this->product_id = $product_id;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function load(array $data): CartLine
    {
        if (key_exists('id', $data))
            $this->setId($data['id']);

        if (key_exists('product_id', $data))
            $this->setProductId($data['product_id']);

        if (key_exists('quantity', $data))
            $this->setQuantity($data['quantity']);

        return $this;
    }

    /**
     * @param $id
     */
    public function setId(int $id): void
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
     * @return array
     */
    public function toArray(): array
    {
        $unset = ['save'];
        $object = get_object_vars($this);

        foreach ($unset as $value){
            unset($object[$value]);
        }

        return $object;
    }

    public function toProduct(): \Omatech\LaravelOrders\Contracts\Product
    {
        return app(\Omatech\LaravelOrders\Contracts\Product::class)->load([
            'id' => $this->product_id,
        ]);
    }

    /**
     *
     */
//    public function save(): void
//    {
//        $this->save->save($this);
//    }
}