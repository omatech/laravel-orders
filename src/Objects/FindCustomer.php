<?php

namespace Omatech\LaravelOrders\Objects;

use Omatech\LaravelOrders\Contracts\Customer;
use Omatech\LaravelOrders\Contracts\FindCustomer as FindCustomerInterface;
use Omatech\LaravelOrders\Repositories\CustomerRepository;

class FindCustomer extends CustomerRepository implements FindCustomerInterface
{

    /**
     * @var Customer
     */
    private $customer;

    /**
     * FindCustomer constructor.
     * @param Customer $customer
     * @throws \Exception
     */
    public function __construct(Customer $customer)
    {
        parent::__construct();
        $this->customer = $customer;
    }

    /**
     * @param int $id
     * @param string $where
     * @return null|Customer
     */
    public function make(int $id, string $where = null)
    {
        if($where){
            $customer = $this->model->where($where, $id)->first();
        }else{
            $customer = $this->model->find($id);
        }

        if (is_null($customer)) {
            return null;
        }

        return $this->customer->load($customer->toArray());
    }
}