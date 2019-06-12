<?php

namespace Omatech\LaravelOrders\Contracts;

interface Cart
{
    public static function find(int $id);

    public function setId($id);

    public function getId();

    public function load(array $data);

    public function save();

    public function push(Product $product);

    public function pop(Product $product);

    public function products();

}