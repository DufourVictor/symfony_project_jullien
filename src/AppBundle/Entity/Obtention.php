<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Obtention
 *
 * @ORM\Table(name="obtention")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ObtentionRepository")
 */
class Obtention
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
     * @ORM\ManyToOne(targetEntity="Student")
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Obtention
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}

