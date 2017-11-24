<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * promote
 *
 * @ORM\Table(name="promote")
 * @ORM\Entity()
 */
class Promote
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
     * @var ArrayCollection[]|Classroom
     * @ORM\ManyToMany(targetEntity="Classroom")
     */
    protected $classroom;

    /**
     * Promote constructor.
     */
    public function __construct()
    {
        $this->classroom = new ArrayCollection();
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
     * @return promote
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
     * @return Classroom|ArrayCollection[]
     */
    public function getClassroom()
    {
        return $this->classroom;
    }

    /**
     * @param Classroom|ArrayCollection[] $classroom
     */
    public function setClassroom($classroom)
    {
        $this->classroom = $classroom;
    }
}

