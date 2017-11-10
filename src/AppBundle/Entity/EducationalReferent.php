<?php

namespace AppBundle\Entity;

use AppBundle\Traits\CommentInformations;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * EducationalReferent
 *
 * @ORM\Table(name="educational_referent")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EducationalReferentRepository")
 */
class EducationalReferent extends BaseUser
{
    use CommentInformations;
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}

