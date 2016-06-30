<?php

namespace GP\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Project
 *
 * @ORM\Table(name="project", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})})
 * @ORM\Entity(repositoryClass="GP\CoreBundle\Repository\ProjectRepository")
 */
class Project
{
    const STATUS_PROJECT_REJECTED = 0;
    const STATUS_PROJECT_WAITING_VALIDATION = 10;
    const STATUS_PROJECT_ACCEPTED = 20;
    const STATUS_PROJECT_STARTED = 30;
    const STATUS_PROJECT_IN_PROGRESS = 40;
    const STATUS_PROJECT_FINISHED = 50;
    const STATUS_PROJECT_ARCHIVED = 60;

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
     *
     * @Assert\NotBlank(message="Vous devez spécifiez un nom de projet")
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "Le nom du projet doit faire un minimum de {{ limit }} caractères",
     *      maxMessage = "Le nom du projet ne peut excéder {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     *
     * @Assert\NotBlank(message="Vous devez spécifiez une description")
     * @Assert\Length(
     *      min = 3,
     *      max = 5000,
     *      minMessage = "La description du projet doit faire un minimum de {{ limit }} caractères",
     *      maxMessage = "La description du projet ne peut excéder {{ limit }} caractères"
     * )
     */
    private $description;

    /**
     * The companies associated to the project
     *
     * @ORM\ManyToMany(targetEntity="GP\CoreBundle\Entity\Company", mappedBy="projects")
     */
    private $companies;

//    @TODO link globals & company categories to projects when created new one.
//    /**
//     * The category of project
//     *
//     * @ORM\ManyToMany(targetEntity="GP\CoreBundle\Entity\ProjectCategory", mappedBy="id", cascade={"persist"})
//     */
//    private $projectCategory;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="begin_date", type="datetime")
     */
    private $beginDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="planned_end_date", type="datetime")
     */
    private $plannedEndDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="real_end_date", type="datetime", nullable=true)
     */
    private $realEndDate;

    /**
     * Registered role for the Project
     *
     * @var AccessRole
     *
     * @ORM\OneToMany(targetEntity="GP\CoreBundle\Entity\AccessRole", mappedBy="project", cascade={"remove"})
     */
    private $projectRoles;

    /**
     * Project constructor.
     */
    public function __construct()
    {
        $this->beginDate = new \DateTime("now");
        $this->companies = new ArrayCollection();
        $this->status = static::STATUS_PROJECT_WAITING_VALIDATION;
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
     * Get project companies
     *
     * @return Company
     */
    public function getCompanies()
    {
        return $this->companies;
    }

    /**
     * Add company to the project
     *
     * @param Company $company
     * @return Project
     */
    public function addCompanies(Company $company)
    {
        $this->companies[] = $company;

        return $this;
    }

    /**
     * Remove company from project
     *
     * @param Company $company
     * @return Project
     */
    public function removeCompanies(Company $company)
    {
        $this->companies->removeElement($company);

        return $this;
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
     * @return \DateTime
     */
    public function getBeginDate()
    {
        return $this->beginDate;
    }

    /**
     * @param \DateTime $beginDate
     */
    public function setBeginDate($beginDate)
    {
        $this->beginDate = $beginDate;
    }

    /**
     * @return \DateTime
     */
    public function getPlannedEndDate()
    {
        return $this->plannedEndDate;
    }

    /**
     * @param \DateTime $plannedEndDate
     */
    public function setPlannedEndDate($plannedEndDate)
    {
        $this->plannedEndDate = $plannedEndDate;
    }

    /**
     * @return \DateTime
     */
    public function getRealEndDate()
    {
        return $this->realEndDate;
    }

    /**
     * @param \DateTime $realEndDate
     */
    public function setRealEndDate($realEndDate)
    {
        $this->realEndDate = $realEndDate;
    }

    /**
     * Get Project Access Role
     *
     * @return AccessRole
     */
    public function getProjectRoles()
    {
        return $this->projectRoles;
    }

    /**
     * Add new Access Role to Project
     *
     * @param AccessRole $projectRoles
     * @return Project
     */
    public function addProjectRoles(AccessRole $projectRoles)
    {
        $this->projectRoles[] = $projectRoles;

        return $this;
    }

    /**
     * Remove given Access Role from Project
     *
     * @param AccessRole $projectRoles
     * @return Project
     */
    public function removeProjectRoles(AccessRole $projectRoles)
    {
        $this->projectRoles->removeElement($projectRoles);

        return $this;
    }

    /**
     * Check if User have access to the given project
     *
     * @param User $user
     * @return bool
     */
    public function checkUserAccess(User $user)
    {
        $access = false;

        $projectCompanies = $this->getCompanies();

        foreach ($projectCompanies as $company) {
            foreach ($company->getUsers() as $companyUser) {
                if ($companyUser->getId() == $user->getId()) {
                    return true;
                }
            }
        }

        return $access;
    }
}
