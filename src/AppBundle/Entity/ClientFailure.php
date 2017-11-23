<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClientFailure
 *
 * @ORM\Table(name="client_failure")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClientFailureRepository")
 */
class ClientFailure
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=255)
     */
    protected $ip;

    /**
     * @var int
     *
     * @ORM\Column(name="numberOfTentative", type="integer")
     */
    protected $numberOfTentative = 0;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    protected $date;

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
     * Set ip
     *
     * @param string $ip
     *
     * @return ClientFailure
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set numberOfTentative
     *
     * @param integer $numberOfTentative
     *
     * @return ClientFailure
     */
    public function setNumberOfTentative($numberOfTentative)
    {
        $this->numberOfTentative = $numberOfTentative;

        return $this;
    }

    /**
     * Get numberOfTentative
     *
     * @return int
     */
    public function getNumberOfTentative()
    {
        return $this->numberOfTentative;
    }

    public function addNumberOfTentative()
    {
        $this->numberOfTentative++;

        return $this;
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
    public function setDate($date)
    {
        $this->date = $date;
    }
}

