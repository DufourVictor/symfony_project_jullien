<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class CertificateObtentionRepository*
 */
class CertificateObtentionRepository extends EntityRepository
{
    public function countNbCertificates($certificate)
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->innerJoin('c.certificate', 'cc')
            ->where('cc.name = :certificate')
            ->setParameter('certificate', $certificate)
            ->getQuery()->getSingleScalarResult();
    }

}
