<?php

namespace GP\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjectRole
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="GP\CoreBundle\Repository\ProjectRoleRepository")
 */
class ProjectRole
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}

