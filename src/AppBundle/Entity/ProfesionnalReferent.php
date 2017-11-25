<?php

namespace AppBundle\Entity;

use AppBundle\Traits\CommentInformations;
use Doctrine\ORM\Mapping as ORM;

/**
 * ProfesionnalReferent
 *
 * @ORM\Table(name="profesionnal_referent")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProfesionnalReferentRepository")
 */
class ProfesionnalReferent
{
    use CommentInformations;
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Company
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="profesionnalReferent")
     */
    protected $company;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param Company $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
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
}

