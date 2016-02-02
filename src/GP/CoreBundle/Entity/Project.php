<?php

namespace GP\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="GP\CoreBundle\Repository\ProjectRepository")
 */
class Project
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
     * @var varchar
     *
     * @ORM\Column(name="name", type="varchar")
     * @ORM\Name
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="GP\CoreBundle\Entity\Company", cascade={"persist"})
     */
    private $company;

    /**
     * @ORM\ManyToMany(targetEntity="GP\CoreBundle\Entity\ProjectCategory", cascade={"persist"})
     */
    private $projectCategory;

    /**
     * @ORM\ManyToMany(targetEntity="GP\CoreBundle\Entity\User", cascade={"persist"})
     */
    private $administratorsList;

    /**
     * @ORM\ManyToMany(targetEntity="GP\CoreBundle\Entity\User", cascade={"persist"})
     */
    private $membersList;

    /**
     * @var varchar
     *
     * @ORM\Column(name="status", type="varchar")
     * @ORM\Status
     */
    private $status;

    /**
     * @var date
     *
     * @ORM\Column(name="begin_date", type="date")
     * @ORM\Begin_date
     */
    private $begin_date;

    /**
     * @var date
     *
     * @ORM\Column(name="planned_end_date", type="date")
     * @ORM\Planned_end_date
     */
    private $planned_end_date;

    /**
     * @var date
     *
     * @ORM\Column(name="real_end_date", type="date")
     * @ORM\Real_end_date
     */
    private $real_end_date;

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

