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
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="GP\CoreBundle\Entity\Company", mappedBy="id", cascade={"persist"})
     */
    private $company;

    /**
     * @ORM\ManyToMany(targetEntity="GP\CoreBundle\Entity\ProjectCategory", mappedBy="id", cascade={"persist"})
     */
    private $projectCategory;

    /**
     * @ORM\ManyToMany(targetEntity="GP\CoreBundle\Entity\User", mappedBy="id", cascade={"persist"})
     */
    private $administratorsList;

    /**
     * @ORM\ManyToMany(targetEntity="GP\CoreBundle\Entity\User", mappedBy="id", cascade={"persist"})
     */
    private $membersList;

    /**
     * @var enum
     *
     * @ORM\Column(name="status", type="string", columnDefinition="ENUM('Waiting validation'))
     */
    private $status;

    /**
     * @var date
     *
     * @ORM\Column(name="begin_date", type="date")
     */
    private $begin_date;

    /**
     * @var date
     *
     * @ORM\Column(name="planned_end_date", type="date")
     */
    private $planned_end_date;

    /**
     * @var date
     *
     * @ORM\Column(name="real_end_date", type="date")
     */
    private $real_end_date;

    /**
     * Project constructor.
     */
    public function __construct()
    {
        $this->begin_date = date("d- m -Y");
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return varchar
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param varchar $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return mixed
     */
    public function getProjectCategory()
    {
        return $this->projectCategory;
    }

    /**
     * @param mixed $projectCategory
     */
    public function setProjectCategory($projectCategory)
    {
        $this->projectCategory = $projectCategory;
    }

    /**
     * @return mixed
     */
    public function getAdministratorsList()
    {
        return $this->administratorsList;
    }

    /**
     * @param mixed $administratorsList
     */
    public function setAdministratorsList($administratorsList)
    {
        $this->administratorsList = $administratorsList;
    }

    /**
     * @return mixed
     */
    public function getMembersList()
    {
        return $this->membersList;
    }

    /**
     * @param mixed $membersList
     */
    public function setMembersList($membersList)
    {
        $this->membersList = $membersList;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return date
     */
    public function getBeginDate()
    {
        return $this->begin_date;
    }

    /**
     * @param date $begin_date
     */
    public function setBeginDate($begin_date)
    {
        $this->begin_date = $begin_date;
    }

    /**
     * @return date
     */
    public function getPlannedEndDate()
    {
        return $this->planned_end_date;
    }

    /**
     * @param date $planned_end_date
     */
    public function setPlannedEndDate($planned_end_date)
    {
        $this->planned_end_date = $planned_end_date;
    }

    /**
     * @return date
     */
    public function getRealEndDate()
    {
        return $this->real_end_date;
    }

    /**
     * @param date $real_end_date
     */
    public function setRealEndDate($real_end_date)
    {
        $this->real_end_date = $real_end_date;
    }


}

