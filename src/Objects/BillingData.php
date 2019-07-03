<?php

namespace Omatech\LaravelOrders\Objects;


use Omatech\LaravelOrders\Contracts\BillingData as BillingDataInterface;

class BillingData implements BillingDataInterface
{
    private $id;
    private $customer_id;
    private $address_first_name;
    private $address_last_name;
    private $address_first_line;
    private $address_second_line;
    private $address_postal_code;
    private $address_city;
    private $address_region;
    private $address_country;
    private $company_name;
    private $cif;
    private $phone_number;

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
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * @param mixed $customer_id
     */
    public function setCustomerId($customer_id): void
    {
        $this->customer_id = $customer_id;
    }

    /**
     * @return mixed
     */
    public function getAddressFirstName()
    {
        return $this->address_first_name;
    }

    /**
     * @param mixed $address_first_name
     */
    public function setAddressFirstName($address_first_name): void
    {
        $this->address_first_name = $address_first_name;
    }

    /**
     * @return mixed
     */
    public function getAddressLastName()
    {
        return $this->address_last_name;
    }

    /**
     * @param mixed $address_last_name
     */
    public function setAddressLastName($address_last_name): void
    {
        $this->address_last_name = $address_last_name;
    }

    /**
     * @return mixed
     */
    public function getAddressFirstLine()
    {
        return $this->address_first_line;
    }

    /**
     * @param mixed $address_first_line
     */
    public function setAddressFirstLine($address_first_line): void
    {
        $this->address_first_line = $address_first_line;
    }

    /**
     * @return mixed
     */
    public function getAddressSecondLine()
    {
        return $this->address_second_line;
    }

    /**
     * @param mixed $address_second_line
     */
    public function setAddressSecondLine($address_second_line): void
    {
        $this->address_second_line = $address_second_line;
    }

    /**
     * @return mixed
     */
    public function getAddressPostalCode()
    {
        return $this->address_postal_code;
    }

    /**
     * @param mixed $address_postal_code
     */
    public function setAddressPostalCode($address_postal_code): void
    {
        $this->address_postal_code = $address_postal_code;
    }

    /**
     * @return mixed
     */
    public function getAddressCity()
    {
        return $this->address_city;
    }

    /**
     * @param mixed $address_city
     */
    public function setAddressCity($address_city): void
    {
        $this->address_city = $address_city;
    }

    /**
     * @return mixed
     */
    public function getAddressRegion()
    {
        return $this->address_region;
    }

    /**
     * @param mixed $address_region
     */
    public function setAddressRegion($address_region): void
    {
        $this->address_region = $address_region;
    }

    /**
     * @return mixed
     */
    public function getAddressCountry()
    {
        return $this->address_country;
    }

    /**
     * @param mixed $address_country
     */
    public function setAddressCountry($address_country): void
    {
        $this->address_country = $address_country;
    }

    /**
     * @return mixed
     */
    public function getCompanyName()
    {
        return $this->company_name;
    }

    /**
     * @param mixed $company_name
     */
    public function setCompanyName($company_name): void
    {
        $this->company_name = $company_name;
    }

    /**
     * @return mixed
     */
    public function getCif()
    {
        return $this->cif;
    }

    /**
     * @param mixed $cif
     */
    public function setCif($cif): void
    {
        $this->cif = $cif;
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
     * @param array $data
     * @return $this
     */
    public function fromArray(array $data): self
    {
        if (key_exists('id', $data))
            $this->setId($data['id']);

        if (key_exists('customer_id', $data))
            $this->setCustomerId($data['customer_id']);

        if (key_exists('address_first_name', $data))
            $this->setAddressFirstName($data['address_first_name']);

        if (key_exists('address_last_name', $data))
            $this->setAddressLastName($data['address_last_name']);

        if (key_exists('address_first_line', $data))
            $this->setAddressFirstLine($data['address_first_line']);

        if (key_exists('address_second_line', $data))
            $this->setAddressSecondLine($data['address_second_line']);

        if (key_exists('address_postal_code', $data))
            $this->setAddressPostalCode($data['address_postal_code']);

        if (key_exists('address_city', $data))
            $this->setAddressCity($data['address_city']);

        if (key_exists('address_region', $data))
            $this->setAddressRegion($data['address_region']);

        if (key_exists('address_country', $data))
            $this->setAddressCountry($data['address_country']);

        if (key_exists('company_name', $data))
            $this->setCompanyName($data['company_name']);

        if (key_exists('cif', $data))
            $this->setCif($data['cif']);

        if (key_exists('phone_number', $data))
            $this->setPhoneNumber($data['phone_number']);

        return $this;
    }

    /**
     * @param array $data
     * @return BillingData
     * @deprecated fromArray should be used directly instead. Will be removed in future versions.
     */
    public function load(array $data): self
    {
        return $this->fromArray($data);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }

}