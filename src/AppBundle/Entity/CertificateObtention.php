<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CertificateObtention
 *
 * @ORM\Table(name="certificate_obtention")
 * @ORM\Entity()
 */
class CertificateObtention
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var Student
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="certificate")
     */
    protected $student;

    /**
     * @var Certificate
     * @ORM\ManyToOne(targetEntity="Certificate")
     */
    protected $certificate;


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
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return Student
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @param Student $student
     */
    public function setStudent(Student $student)
    {
        $this->student = $student;
    }

    /**
     * @return Certificate
     */
    public function getCertificate()
    {
        return $this->certificate;
    }

    /**
     * @param Certificate $certificate
     */
    public function setCertificate(Certificate $certificate)
    {
        $this->certificate = $certificate;
    }
}

