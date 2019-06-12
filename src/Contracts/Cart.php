<?php

namespace Omatech\LaravelOrders\Contracts;

interface Cart
{
    public function load(array $data);

    public function setId($id);

    public function getId();

    public static function find(int $id);

}