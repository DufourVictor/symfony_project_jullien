<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Register
 *
 * @ORM\Table(name="register")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RegisterRepository")
 */
class Register
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
     * @var Classroom
     * @ORM\ManyToOne(targetEntity="Classroom")
     */
    protected $classroom;

    /**
     * @var Promote
     * @ORM\ManyToOne(targetEntity="Promote")
     */
    protected $promote;

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
     * @return Classroom
     */
    public function getClassroom()
    {
        return $this->classroom;
    }

    /**
     * @param Classroom $classroom
     */
    public function setClassroom($classroom)
    {
        $this->classroom = $classroom;
    }

    /**
     * @return Promote
     */
    public function getPromote()
    {
        return $this->promote;
    }

    /**
     * @param Promote $promote
     */
    public function setPromote($promote)
    {
        $this->promote = $promote;
    }
}

