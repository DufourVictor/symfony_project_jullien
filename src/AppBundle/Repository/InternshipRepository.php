<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Company;
use AppBundle\Entity\Student;
use Doctrine\ORM\EntityRepository;

/**
 * Class InternshipRepository
 */
class InternshipRepository extends EntityRepository
{
    /**
     * @param Student $student
     *
     * @return array
     */
    public function findStagesForUser(Student $student)
    {
        return $this->createQueryBuilder('i')
            ->where('i.student = :student')
            ->setParameter('student', $student)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Student $student
     *
     * @return array
     */
    public function findYearPromotionForUser(Student $student)
    {
        return $this->createQueryBuilder('i')
            ->select('p.name')
            ->innerJoin('i.student', 's')
            ->innerJoin('s.register', 'r')
            ->innerJoin('r.promote', 'p')
            ->where('i.student = :student')
            ->setParameter('student', $student)
            ->getQuery()
            ->getScalarResult();
    }

    /**
     * @param Company $company
     *
     * @return array
     */
    public function findInternshipForCompany(Company $company)
    {
        return $this->createQueryBuilder('i')
            ->where('i.company = :company')
            ->setParameter('company', $company)
            ->getQuery()
            ->getResult();
    }
}
