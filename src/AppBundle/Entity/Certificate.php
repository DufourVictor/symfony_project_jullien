<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Certificate
 *
 * @ORM\Table(name="certificate")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CertificateRepository")
 */
class Certificate
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
     * @var ArrayCollection[]|Student
     * @ORM\ManyToMany(targetEntity="Student")
     */
    protected $student;

    /**
     * Certificate constructor.
     */
    function __construct()
    {
        $this->student = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Certificate
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
     * @return Student|ArrayCollection[]
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @param Student|ArrayCollection[] $student
     */
    public function setStudent($student)
    {
        $this->student = $student;
    }
}
