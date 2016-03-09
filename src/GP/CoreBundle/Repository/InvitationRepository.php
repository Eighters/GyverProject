<?php

namespace GP\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * InvitationRepository
 */
class InvitationRepository extends EntityRepository
{
    public function findAllInvitationAndOrderByDate()
    {
        return $this->createQueryBuilder('i')
            ->orderBy('i.sentAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
}
