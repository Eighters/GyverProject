<?php

namespace GP\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use GP\CoreBundle\Entity\User;

/**
 * Company Repository
 */
class CompanyRepository extends EntityRepository
{
    /**
     * Get all companies attached to the given user
     *
     * @param User $user
     * @param null $limit
     * @return array
     */
    public function findUserCompanies(User $user, $limit = null)
    {
        $companies = $this->createQueryBuilder('c')
            ->select('c')
            ->join('c.users', 'u')
            ->where('u = :user')
            ->setParameter('user', $user->getId())
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;

        return $companies;
    }
}
