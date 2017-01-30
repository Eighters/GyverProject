<?php

namespace GP\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use GP\CoreBundle\Validator\Constraints as CustomAssert;

/**
 * Project
 *
 * @ORM\Table(name="project", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})})
 * @ORM\Entity(repositoryClass="GP\CoreBundle\Repository\ProjectRepository")
 *
 * @CustomAssert\Project
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
     * @ORM\Column(name="besoin", type="text")
     *
     * @Assert\NotBlank(message="Vous devez spécifiez le besoin")
     * @Assert\Length(
     *      min = 3,
     *      max = 2000,
     *      minMessage = "Le besoin du projet doit faire un minimum de {{ limit }} caractères",
     *      maxMessage = "Le besoin du projet ne peut excéder {{ limit }} caractères"
     * )
     */
    private $besoin;
    
    /**
     * @var string
     *
     * @ORM\Column(name="origine", type="string")
     *
     * @Assert\NotBlank(message="Vous devez spécifiez l'origine de projet")
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "L'origine du projet doit faire un minimum de {{ limit }} caractères",
     *      maxMessage = "L'origine du projet ne peut excéder {{ limit }} caractères"
     * )
     */
    private $origine;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     *
     * @Assert\NotBlank(message="Vous devez spécifiez une description")
     * @Assert\Length(
     *      min = 3,
     *      max = 2000,
     *      minMessage = "La description du projet doit faire un minimum de {{ limit }} caractères",
     *      maxMessage = "La description du projet ne peut excéder {{ limit }} caractères"
     * )
     */
    private $description;
    
    /**
     * @var string
     *
     * @ORM\Column(name="benefices", type="text")
     *
     * @Assert\NotBlank(message="Vous devez spécifiez les bénéfices")
     * @Assert\Length(
     *      min = 3,
     *      max = 2000,
     *      minMessage = "Les bénéfices du projet doivent faire un minimum de {{ limit }} caractères",
     *      maxMessage = "Les bénéfices du projet ne peut excéder {{ limit }} caractères"
     * )
     */
    private $benefices;

    /**
     * The companies associated to the project
     *
     * @var Company
     *
     * @ORM\ManyToMany(targetEntity="GP\CoreBundle\Entity\Company", mappedBy="projects", cascade={"persist"})
     */
    private $companies;

    /**
     * The category of project
     *
     * @var ProjectCategory
     *
     * @ORM\OneToMany(targetEntity="GP\CoreBundle\Entity\ProjectCategory", mappedBy="project", cascade={"persist", "remove"})
     */
    private $projectCategory;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * Project creation date
     *
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime", nullable=false)
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="begin_date", type="datetime", nullable=true)
     */
    private $beginDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="planned_end_date", type="datetime", nullable=true)
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
        $this->creationDate = new \DateTime("now");
        $this->companies = new ArrayCollection();
        $this->projectCategory = new ArrayCollection();
        $this->projectRoles = new ArrayCollection();
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
    public function getBesoin()
    {
        return $this->besoin;
    }

    /**
     * @param string $besoin
     */
    public function setBesoin($besoin)
    {
        $this->besoin = $besoin;
    }
    
    /**
     * @return string
     */
    public function getOrigine()
    {
        return $this->origine;
    }

    /**
     * @param string $origine
     */
    public function setOrigine($origine)
    {
        $this->origine = $origine;
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
     * @return string
     */
    public function getBenefices()
    {
        return $this->benefices;
    }

    /**
     * @param string $benefices
     */
    public function setBenefices($benefices)
    {
        $this->benefices = $benefices;
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
     * Avoid bug with doctrine
     *
     * @param Company $company
     * @return Project
     */
    public function setCompanies($company)
    {
        $this->companies[] = $company;

        return $this;
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
     * Get ProjectCategory
     *
     * @return ProjectCategory
     */
    public function getProjectCategory()
    {
        return $this->projectCategory;
    }

    /**
     * Add new Project Category to Project
     *
     * @param ProjectCategory $projectCategory
     * @return Project
     */
    public function addProjectCategory(ProjectCategory $projectCategory)
    {
        $this->projectRoles[] = $projectCategory;

        return $this;
    }

    /**
     * Remove given Project Category from Project
     *
     * @param ProjectCategory $projectCategory
     * @return Project
     */
    public function removeProjectCategory(ProjectCategory $projectCategory)
    {
        $this->projectRoles->removeElement($projectCategory);

        return $this;
    }

    /**
     * Set ProjectCategory
     *
     * @param ProjectCategory $projectCategory
     * @return Project
     */
    public function setProjectCategory($projectCategory)
    {
        $this->projectCategory[] = $projectCategory;

        return $this;
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
     * Get creation date
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set creation date
     *
     * @param \DateTime $creationDate
     * @return Company
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
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
