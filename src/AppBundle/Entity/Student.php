<?php

namespace AppBundle\Entity;

use AppBundle\Traits\CommentInformations;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Student
 *
 * @ORM\Table(name="student")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StudentRepository")
 */
class Student
{
    use CommentInformations;
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text")
     */
    protected $address;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @var Certificate[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="Certificate", mappedBy="student")
     */
    protected $certificate;

    /**
     * @var Register
     * @ORM\OneToMany(targetEntity="Register", mappedBy="student")
     */
    protected $register;

    /**
     * Student constructor.
     */
    public function __construct()
    {
        $this->certificate = new ArrayCollection();
    }

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
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return Certificate[]|ArrayCollection
     */
    public function getCertificate()
    {
        return $this->certificate;
    }

    /**
     * @param Certificate[]|ArrayCollection $certificate
     */
    public function setCertificate($certificate)
    {
        $this->certificate = $certificate;
    }

    /**
     * @return Register
     */
    public function getRegister()
    {
        return $this->register;
    }

    /**
     * @param Register $register
     */
    public function setRegister($register)
    {
        $this->register = $register;
    }
}
