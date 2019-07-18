<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

/**
 * Class Address
 * @package HisInOneProxy\DataModel
 */
class Address
{
    use Traits\ObjGuid, Traits\SortingOrder, Traits\UpdatedAt, Traits\Valid;

    /**
     * @var string
     */
    protected $post_code;

    /**
     * @var string
     */
    protected $street;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $address_addition;

    /**
     * @var string
     */
    protected $address_tag_id;

    /**
     * @var string
     */
    protected $org_unit_lid;

    /**
     * @var string
     */
    protected $building_id;

    /**
     * @var string
     */
    protected $post_box_office;

    /**
     * @var string
     */
    protected $company;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var int
     */
    protected $country_id;

    /**
     * @var
     */
    protected $created_at;

    /**
     * @var string
     */
    protected $person_id;

    /**
     * @return string
     */
    public function getPostCode()
    {
        return $this->post_code;
    }

    /**
     * @param string $post_code
     */
    public function setPostCode($post_code)
    {
        $this->post_code = $post_code;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getAddressAddition()
    {
        return $this->address_addition;
    }

    /**
     * @param string $address_addition
     */
    public function setAddressAddition($address_addition)
    {
        $this->address_addition = $address_addition;
    }

    /**
     * @return string
     */
    public function getPostBoxOffice()
    {
        return $this->post_box_office;
    }

    /**
     * @param string $post_box_office
     */
    public function setPostBoxOffice($post_box_office)
    {
        $this->post_box_office = $post_box_office;
    }

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param string $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return int
     */
    public function getCountryId()
    {
        return $this->country_id;
    }

    /**
     * @param int $country_id
     */
    public function setCountryId($country_id)
    {
        $this->country_id = $country_id;
    }

    /**
     * @return string
     */
    public function getAddressTagId()
    {
        return $this->address_tag_id;
    }

    /**
     * @param string $address_tag_id
     */
    public function setAddressTagId($address_tag_id)
    {
        $this->address_tag_id = $address_tag_id;
    }

    /**
     * @return string
     */
    public function getOrgUnitLid()
    {
        return $this->org_unit_lid;
    }

    /**
     * @param string $org_unit_lid
     */
    public function setOrgUnitLid($org_unit_lid)
    {
        $this->org_unit_lid = $org_unit_lid;
    }

    /**
     * @return string
     */
    public function getBuildingId()
    {
        return $this->building_id;
    }

    /**
     * @param string $building_id
     */
    public function setBuildingId($building_id)
    {
        $this->building_id = $building_id;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return string
     */
    public function getPersonId()
    {
        return $this->person_id;
    }

    /**
     * @param string $person_id
     */
    public function setPersonId($person_id)
    {
        $this->person_id = $person_id;
    }
}