<?php

namespace GP\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use GP\CoreBundle\Entity\Company;

/**
 * Project Repository
 */
class ProjectRepository extends EntityRepository
{
    CONST CUSTOMER= 'customer';
    CONST SUPPLIER= 'supplier';

    public function findProject(Company $company, $type)
    {
        $projects = $this->createQueryBuilder('p')
            ->where('p.'.$type.'Company = :company')
            ->setParameter('company', $company)
            ->getQuery()
            ->getResult()
        ;

        return $projects;
    }
}
