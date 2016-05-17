<?php

namespace GP\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use GP\CoreBundle\Entity\Company;

/**
 * Project Repository
 */
class ProjectRepository extends EntityRepository
{
    /**
     * Return number of finished project for the given company
     *
     * status 50 = finished
     * status 60 = archived
     *
     * @param Company $company
     * @return integer
     */
    public function countFinishedProjects(Company $company)
    {
        $result = $this->createQueryBuilder('project')
            ->select('COUNT(project)')
            ->join('project.companies', 'companies')
            ->where('companies = :company')
            ->andWhere('project.status = 50 OR project.status = 60')
            ->setParameter('company', $company->getId())
            ->getQuery()->getSingleScalarResult()
        ;

        return $result;
    }

    /**
     * Return number of project in progress for the given company
     *
     * status 20 = accepted
     * status 30 = started
     * status 40 = in progress
     *
     * @param Company $company
     * @return integer
     */
    public function countProjectsInProgress(Company $company)
    {
        $result = $this->createQueryBuilder('project')
            ->select('COUNT(project)')
            ->join('project.companies', 'companies')
            ->where('companies = :company')
            ->andWhere('project.status = 20 OR project.status = 30 OR project.status = 40')
            ->setParameter('company', $company->getId())
            ->getQuery()->getSingleScalarResult()
        ;

        return $result;
    }
}
