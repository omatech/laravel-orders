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

        $deliveryAddresses = $customer->getDeliveryAddresses();

        foreach ($deliveryAddresses as $deliveryAddress) {
            $currentDeliveryAddress = $deliveryAddress->toArray();
            $currentDeliveryAddress['customer_id'] = $customer->getId();

            $model->deliveryAddresses()->updateOrCreate([
                'customer_id' => $currentDeliveryAddress['customer_id'],
                'first_line' => $currentDeliveryAddress['first_line'],
                'second_line' => $currentDeliveryAddress['second_line'],
                'postal_code' => $currentDeliveryAddress['postal_code'],
            ], $currentDeliveryAddress);
        }
    }

    public function saveIfNotExists(Customer &$customer)
    {
        $model = $this->model;
        $data = $customer->toArray();

        if (!empty($data)) {

            if (!empty($data['id'])) {
                $model = $model->where('id', $data['id']);
            } else {
                $uniqueFieldsCombo = [
                    'first_name',
                    'last_name',
                    'birthday',
                    'phone_number',
                    'gender'
                ];
                foreach ($data as $datumKey => $datumValue) {
                    if (in_array($datumKey, $uniqueFieldsCombo)) {
                        $model = $model->where($datumKey, $datumValue);
                    }
                }
            }

        }

        $exists = $model->first();

        if (is_null($exists)) {
            $this->save($customer);
        } else {
            throw new CustomerAlreadyExistsException();
        }
    }
}