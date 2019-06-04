<?php

namespace Omatech\LaravelOrders\Repositories\Customer;

use Omatech\LaravelOrders\Contracts\Customer;
use Omatech\LaravelOrders\Contracts\SaveCustomer as SaveCustomerInterface;
use Omatech\LaravelOrders\Exceptions\Customer\CustomerAlreadyExistsException;
use Omatech\LaravelOrders\Repositories\CustomerRepository;

class SaveCustomer extends CustomerRepository implements SaveCustomerInterface
{

    public function save(Customer &$customer)
    {
        $model = $this->model;

        if (!is_null($customer->getId())) {
            $model = $model->find($customer->getId());

            if (is_null($model)) {
                $model = $this->model->create();
            }
        }

        $model->fill($customer->toArray());

        $model->saveOrFail();

        $customer->setId($model->id);
    }

    public function saveIfNotExists(Customer &$customer)
    {
        $model = $this->model;
        $data = $customer->toArray();

        if (!empty($data)) {

            if (!empty($data['id'])) {
                $model = $model->where('id', $data['id']);
            } else {
                unset($data['id']);
                foreach ($data as $datumKey => $datumValue) {
                    $model = $model->where($datumKey, $datumValue);
                }
            }

        }

        $exists = $model->first();

        if (is_null($exists)) {
            $this->save($customer);
        }else{
            throw new CustomerAlreadyExistsException();
        }
    }
}