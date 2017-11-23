<?php
namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;

/**
 * Class Address
 * @ORM\Embeddable()
 * @ORM\Table(name="address")
 */
class Address
{
    /**
     * @Column(type="string", nullable=true)
     */
    protected $street;

    /**
     * @Column(type="string", nullable=true)
     */
    protected $postalCode;

    /**
     * @Column(type="string", nullable=true)
     */
    protected $city;

    /**
     * @Column(type="string", nullable=true)
     */
    protected $country;

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $street
     *
     * @return Address
     */
    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param mixed $postalCode
     *
     * @return Address
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
        return $this;
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
     *
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
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
     *
     * @return Address
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return mixed
     */
    public function fullAddress(){
        return $this->getStreet() .' '.$this->getCity().' '.$this->getPostalCode().' '.$this->getCountry();
    }
}