<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Internship
 *
 * @ORM\Table(name="internship")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InternshipRepository")
 */
class Internship
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
     * @ORM\Column(name="startDate", type="datetime")
     */
    protected $startDate;

    /**
     * @var \DateTime
     * @ORM\Column(name="endDate", type="datetime")
     */
    protected $endDate;

    /**
     * @var Company
     * @ORM\ManyToOne(targetEntity="Company")
     */
    protected $company;

    /**
     * @var Student
     * @ORM\ManyToOne(targetEntity="Student")
     */
    protected $student;

    /**
     * @var ProfesionnalReferent
     * @ORM\ManyTOOne(targetEntity="ProfesionnalReferent")
     */
    protected $profesionnalReferent;

    /**
     * @var EducationalReferent
     * @ORM\ManyToOne(targetEntity="EducationalReferent")
     */
    protected $educationalReferent;

    /**
     * @var ArrayCollection[]|Technology
     * @ORM\ManyToMany(targetEntity="Technology")
     */
    protected $technologies;

    /**
     * Internship constructor.
     */
    function __construct()
    {
        $this->technologies = new ArrayCollection();
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
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
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
     * @return Student
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @param Student $student
     */
    public function setStudent($student)
    {
        $this->student = $student;
    }

    /**
     * @return ProfesionnalReferent
     */
    public function getProfesionnalReferent()
    {
        return $this->profesionnalReferent;
    }

    /**
     * @param ProfesionnalReferent $profesionnalReferent
     */
    public function setProfesionnalReferent($profesionnalReferent)
    {
        $this->profesionnalReferent = $profesionnalReferent;
    }

    /**
     * @return EducationalReferent
     */
    public function getEducationalReferent()
    {
        return $this->educationalReferent;
    }

    /**
     * @param EducationalReferent $educationalReferent
     */
    public function setEducationalReferent($educationalReferent)
    {
        $this->educationalReferent = $educationalReferent;
    }

    /**
     * @return Technology|ArrayCollection[]
     */
    public function getTechnologies()
    {
        return $this->technologies;
    }

    /**
     * @param Technology|ArrayCollection[] $technologies
     */
    public function setTechnologies($technologies)
    {
        $this->technologies = $technologies;
    }
}
