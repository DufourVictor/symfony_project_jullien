<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Company
 *
 * @ORM\Table(name="company")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompanyRepository")
 */
class Company
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var CompanyType
     *
     * @ORM\ManyToOne(targetEntity="CompanyType")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="turnover", type="string", length=255)
     */
    private $turnover;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="phoneNumber", type="string", length=255)
     */
    private $phoneNumber;

    /**
     * @var ProfesionnalReferent
     *
     * @ORM\OneToMany(targetEntity="ProfesionnalReferent", mappedBy="company")
     */
    protected $profesionnalReferent;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Company
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return CompanyType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param CompanyType $type
     */
    public function setType(CompanyType $type)
    {
        $this->type = $type;
    }

    /**
     * Set turnover
     *
     * @param string $turnover
     *
     * @return Company
     */
    public function setTurnover($turnover)
    {
        $this->turnover = $turnover;

        return $this;
    }

    /**
     * Get turnover
     *
     * @return string
     */
    public function getTurnover()
    {
        return $this->turnover;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return Company
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @return ProfesionnalReferent
     */
    public function getProfesionnalReferent()
    {
        return $this->profesionnalReferent;
    }

    /**
     * @param ProfesionnalReferent $profesionnalReferent
     */
    public function setProfesionnalReferent(ProfesionnalReferent $profesionnalReferent)
    {
        $this->profesionnalReferent = $profesionnalReferent;
    }
}

