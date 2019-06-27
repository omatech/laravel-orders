<?php

namespace Omatech\LaravelOrders\Repositories\Customer;

use Omatech\LaravelOrders\Contracts\Customer;
use Omatech\LaravelOrders\Contracts\FindCustomer as FindCustomerInterface;
use Omatech\LaravelOrders\Contracts\Order;
use Omatech\LaravelOrders\Repositories\CustomerRepository;

class FindCustomer extends CustomerRepository implements FindCustomerInterface
{

    /**
     * @var Customer
     */
    private $customer;
    /**
     * @var Order
     */
    private $order;

    /**
     * FindCustomer constructor.
     * @param Customer $customer
     * @param Order $order
     * @throws \Exception
     */
    public function __construct(Customer $customer, Order $order)
    {
        parent::__construct();
        $this->customer = $customer;
        $this->order = $order;
    }

    /**
     * @param int $id
     * @param string $where
     * @return null|Customer
     */
    public function make(int $id, string $where = null)
    {
        if($where){
            $customer = $this->model->with('orders')->where($where, $id)->first();
        }else{
            $customer = $this->model->with('orders')->find($id);
        }

        if (is_null($customer)) {
            return null;
        }

        //Products
        $orders = $customer->orders()->get();

        foreach ($orders as $order) {
            $currentOrder = $this->order->fromArray([
                'id' => $order->id,
                'customerId' => $order->customer_id
            ]);

            $this->customer->setOrder($currentOrder);
        }

        return $this->customer->load($customer->toArray());
    }
}