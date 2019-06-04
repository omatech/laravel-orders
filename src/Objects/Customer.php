<?php

namespace Omatech\LaravelOrders\Objects;

use Omatech\LaravelOrders\Contracts\SaveCustomer;

class Customer implements \Omatech\LaravelOrders\Contracts\Customer
{
    private $id;
    private $first_name;
    private $last_name;
    private $birthday;
    private $phone_number;
    private $gender;

    private $save;

    public function __construct(SaveCustomer $save)
    {
        $this->save = $save;

        if (config('orders.options.users.enabled') === true) {
            $this->user_id = null;
        }
    }

    /**
     * @param array $data
     * @return $this
     */
    public function load(array $data): self
    {
        if (key_exists('id', $data))
            $this->setId($data['id']);

        if (key_exists('first_name', $data))
            $this->setFirstName($data['first_name']);

        if (key_exists('last_name', $data))
            $this->setLastName($data['last_name']);

        if (key_exists('birthday', $data))
            $this->setBirthday($data['birthday']);

        if (key_exists('phone_number', $data))
            $this->setPhoneNumber($data['phone_number']);

        if (key_exists('gender', $data))
            $this->setGender($data['gender']);

        if (key_exists('user_id', $data))
            $this->setUserId($data['user_id']);

        return $this;
    }

    public function save(): void
    {
        $this->save->save($this);
    }

    public function saveIfNotExists(): void
    {
        $this->save->saveIfNotExists($this);
    }

    public function toArray(): array
    {
        $unset = ['save'];
        $object = get_object_vars($this);

        foreach ($unset as $value) {
            unset($object[$value]);
        }

        return $object;
    }

    /**
     * @return mixed
     */
    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param mixed $birthday
     */
    public function setBirthday($birthday): void
    {
        $this->birthday = $birthday;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * @param mixed $phone_number
     */
    public function setPhoneNumber($phone_number): void
    {
        $this->phone_number = $phone_number;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender): void
    {
        $this->gender = $gender;
    }
}