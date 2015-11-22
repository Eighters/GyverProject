<?php

namespace GP\ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjectRole
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="GP\ProjectBundle\Entity\ProjectRoleRepository")
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

