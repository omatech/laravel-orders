<?php

namespace Omatech\LaravelOrders\Repositories\Customer;

use Omatech\LaravelOrders\Contracts\Customer;
use Omatech\LaravelOrders\Repositories\CustomerRepository;

class FindAllCustomers extends CustomerRepository implements \Omatech\LaravelOrders\Contracts\FindAllCustomers
{
    /**
     * @var Customer
     */
    private $customer;

    /**
     * FindAllCustomers constructor.
     * @param Customer $customer
     * @throws \Exception
     */
    public function __construct(Customer $customer)
    {
        parent::__construct();
        $this->customer = $customer;
    }

    /**
     * @return array
     */
    public function make(): array
    {
        $return = [];
        $all = $this->model->all();

        if (empty($all)) {
            return $return;
        }

        foreach ($all as $value) {
            $customer = $this->customer;
            array_push($return, $customer->fromArray($value->toArray()));
        }

        return $return;
    }
}