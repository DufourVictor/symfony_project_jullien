<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Student;
use Doctrine\ORM\EntityRepository;
/**
 * Class InternshipRepository
 */
class InternshipRepository extends EntityRepository
{
    public function findStagesForUser(Student $student)
    {
        return $this->createQueryBuilder('i')
            ->where('i.student = :student')
            ->setParameter('student', $student)
            ->getQuery()
            ->getResult();
    }
}
