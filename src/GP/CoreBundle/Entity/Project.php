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
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

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
     * @ORM\Column(name="status", type="string", columnDefinition="enum('Waiting validation')")
     */
    private $status;

    /**
     * @var date
     *
     * @ORM\Column(name="begin_date", type="date")
     */
    private $beginDate;

    /**
     * @var date
     *
     * @ORM\Column(name="planned_end_date", type="date")
     */
    private $plannedEndDate;

    /**
     * @var date
     *
     * @ORM\Column(name="real_end_date", type="date")
     */
    private $realEndDate;

    /**
     * Project constructor.
     */
    public function __construct()
    {
        $this->beginDate = date("d- m -Y");
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
     * @return enum
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param enum $status
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
        return $this->beginDate;
    }

    /**
     * @param date $beginDate
     */
    public function setBeginDate($beginDate)
    {
        $this->beginDate = $beginDate;
    }

    /**
     * @return date
     */
    public function getPlannedEndDate()
    {
        return $this->plannedEndDate;
    }

    /**
     * @param date $plannedEndDate
     */
    public function setPlannedEndDate($plannedEndDate)
    {
        $this->plannedEndDate = $plannedEndDate;
    }

    /**
     * @return date
     */
    public function getRealEndDate()
    {
        return $this->realEndDate;
    }

    /**
     * @param date $realEndDate
     */
    public function setRealEndDate($realEndDate)
    {
        $this->realEndDate = $realEndDate;
    }



}

