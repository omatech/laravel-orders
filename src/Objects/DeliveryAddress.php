<?php

namespace Omatech\LaravelOrders\Objects;


class DeliveryAddress implements \Omatech\LaravelOrders\Contracts\DeliveryAddress
{
    private $first_name;
    private $last_name;
    private $first_line;
    private $second_line;
    private $postal_code;
    private $city;
    private $region;
    private $country;
    private $is_a_company;
    private $company_name;

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
    public function getFirstLine()
    {
        return $this->first_line;
    }

    /**
     * @param mixed $first_line
     */
    public function setFirstLine($first_line): void
    {
        $this->first_line = $first_line;
    }

    /**
     * @return mixed
     */
    public function getSecondLine()
    {
        return $this->second_line;
    }

    /**
     * @param mixed $second_line
     */
    public function setSecondLine($second_line): void
    {
        $this->second_line = $second_line;
    }

    /**
     * @return mixed
     */
    public function getPostalCode()
    {
        return $this->postal_code;
    }

    /**
     * @param mixed $postal_code
     */
    public function setPostalCode($postal_code): void
    {
        $this->postal_code = $postal_code;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param mixed $region
     */
    public function setRegion($region): void
    {
        $this->region = $region;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getIsACompany()
    {
        return $this->is_a_company;
    }

    /**
     * @param mixed $is_a_company
     */
    public function setIsACompany($is_a_company): void
    {
        $this->is_a_company = $is_a_company;
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

        if (key_exists('first_line', $data))
            $this->setFirstLine($data['first_line']);

        if (key_exists('second_line', $data))
            $this->setSecondLine($data['second_line']);

        if (key_exists('postal_code', $data))
            $this->setPostalCode($data['postal_code']);

        if (key_exists('city', $data))
            $this->setCity($data['city']);

        if (key_exists('region', $data))
            $this->setRegion($data['region']);

        if (key_exists('country', $data))
            $this->setCountry($data['country']);

        if (key_exists('is_a_company', $data))
            $this->setIsACompany($data['is_a_company']);

        if (key_exists('company_name', $data))
            $this->setCompanyName($data['company_name']);

        return $this;
    }

    public function toArray(): array
    {
        $object = get_object_vars($this);
        return $object;
    }
}