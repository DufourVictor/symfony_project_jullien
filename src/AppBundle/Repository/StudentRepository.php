<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class StudentRepository
 *
 */
class StudentRepository extends EntityRepository
{
    public function getStudentsByClass($idClass)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.register', 'r')
            ->innerJoin('r.classroom', 'c')
            ->where('c.id = :idClass')
            ->setParameter('idClass', $idClass)
            ->getQuery()->getArrayResult()
        ;
    }
}
