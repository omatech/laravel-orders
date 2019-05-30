<?php

namespace Omatech\LaravelOrders\Repositories\Order;

use Omatech\LaravelOrders\Exceptions\Order\CreateOrderException;
use Omatech\LaravelOrders\Repositories\OrderRepository;

class CreateOrder extends OrderRepository
{
    /**
     * @param array $fields
     * @return mixed
     * @throws \Throwable
     */
    public function __invoke(array $fields)
    {
        return $this->make($fields);
    }

    /**
     * @param array $fields
     * @return mixed
     * @throws \Throwable
     */
    public function make(array $fields)
    {
        $this->validate($fields);

        $order = $this->model->create($fields);

        throw_if($order === null, new CreateOrderException());

        return $order;
    }

    /**
     * @param array $fields
     */
    private function validate(array $fields)
    {
        $errors = [];

//        if(empty($fields['status']))
//        {
//            $errors['status'] = 'A Status is required';
//
//        }elseif(!in_array($fields['status'], config('orders.status')))
//        {
//            $errors['status'] = 'Invalid Status';
//        }
//
//        if(empty($fields['code']))
//        {
//            $errors['code'] = 'A Code is required';
//        }


        if(!empty($errors))
        {
            throw ValidationException::withMessages($errors);
        }
    }
}