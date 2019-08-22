<?php

namespace Omatech\LaravelOrders\Api;

class Order
{
    /**
     * @var \Omatech\LaravelOrders\Contracts\Order
     */
    private $order;

    /**
     * Order constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->order = app()->make(\Omatech\LaravelOrders\Contracts\Order::class);
    }

    /**
     * @param array $data
     * @return \Omatech\LaravelOrders\Contracts\Order|bool
     */
    public function create(array $data = [])
    {
        try{
            $order = $this->order->fromArray($data);
            $order->save();
            $order = $this->order::find($order->getId());
        }catch (\Exception $exception){
            $order = false;
        }catch (\TypeError $error){
            $order = false;
        }

        return $order;
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $order = $this->order::find($id);

        if (is_null($order)) {
            return false;
        }

        if (isset($data['id'])) unset($data['id']);

        $order->fromArray($data);
        $order->save();

        return true;
    }
}