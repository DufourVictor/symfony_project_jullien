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
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $address;

    /**
     * @var CertificateObtention[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="CertificateObtention", mappedBy="student", cascade={"persist"})
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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return CertificateObtention[]|ArrayCollection
     */
    public function getCertificate()
    {
        return $this->certificate;
    }

    /**
     * @param CertificateObtention[]|ArrayCollection $certificate
     */
    public function setCertificate($certificate)
    {
        $this->certificate = $certificate;
    }

    /**
     * @param CertificateObtention $certificate
     *
     * @return $this
     */
    public function addCertificate(CertificateObtention $certificate)
    {
        $certificate->setStudent($this);
        $this->certificate->add($certificate);

        return $this;
    }

    /**
     * @param CertificateObtention $certificate
     *
     * @return $this
     */
    public function removeCertificate(CertificateObtention $certificate)
    {
        $this->certificate->removeElement($certificate);

        return $this;
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
    public function setRegister(Register $register)
    {
        $this->register = $register;
    }

}
