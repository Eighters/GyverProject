<?php

namespace GP\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use GP\CoreBundle\Entity\ProjectCategory;

/**
 * Company
 *
 * @ORM\Table(name="company", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})})
 * @ORM\Entity(repositoryClass="GP\CoreBundle\Repository\CompanyRepository")
 */
class Company
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
     * Company Name
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     *
     * @Assert\NotBlank(message="La compagnie doit avoir un nom")
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "Le nom de l'entreprise doit faire un minimum de {{ limit }} caractères",
     *      maxMessage = "Le nom de l'entreprise ne peut excéder {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     * Company Description
     *
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     *
     * @Assert\NotBlank(message="La compagnie doit avoir une description")
     * @Assert\Length(
     *      min = 3,
     *      max = 5000,
     *      minMessage = "La description de l'entreprise doit faire un minimum de {{ limit }} caractères",
     *      maxMessage = "La description de l'entreprise ne peut excéder {{ limit }} caractères"
     * )
     */
    private $description;

    /**
     * Company Creation Date
     *
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;

    /**
     * The ProjectCategory associated to the Company
     *
     * @var ProjectCategory
     *
     * @ORM\OneToMany(targetEntity="GP\CoreBundle\Entity\ProjectCategory", mappedBy="company", cascade={"remove", "persist"})
     */
    private $projectCategory;

    /**
     * The projects of the company
     *
     * @var Project
     *
     * @ORM\ManyToMany(targetEntity="GP\CoreBundle\Entity\Project", inversedBy="companies", cascade={"persist"})
     * @ORM\JoinTable(name="company_projects")
     */
    private $projects;

    /**
     * A collection of user associated to the project
     *
     * @var User
     *
     * @ORM\ManyToMany(targetEntity="GP\CoreBundle\Entity\User", mappedBy="companies", cascade={"persist"})
     */
    private $users;

    /**
     * Registered role for the Company
     *
     * @var AccessRole
     *
     * @ORM\OneToMany(targetEntity="GP\CoreBundle\Entity\AccessRole", mappedBy="company", cascade={"remove", "persist"})
     */
    private $companyRoles;

    /**
     * Company constructor.
     */
    public function __construct()
    {
        $this->creationDate = new \DateTime("now");
        $this->projects = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->companyRoles = new ArrayCollection();
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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Company
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Company
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
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
     * Get ProjectCategory
     *
     * @return ProjectCategory
     */
    public function getProjectCategory()
    {
        return $this->projectCategory;
    }

    /**
     * Set ProjectCategory
     *
     * @param ProjectCategory $projectCategory
     * @return Company
     */
    public function setProjectCategory(ProjectCategory $projectCategory)
    {
        $this->projectCategory = $projectCategory;

        return $this;
    }

    /**
     * Get projects of the company
     *
     * @return ArrayCollection
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * Add new project to the company
     *
     * @param Project $project
     * @return Company
     */
    public function addProject(Project $project)
    {
        $this->projects[] = $project;

        return $this;
    }

    /**
     * Remove given project from the company
     *
     * @param Project $project
     * @return Company
     */
    public function removeProject(Project $project)
    {
        $this->projects->removeElement($project);

        return $this;
    }

    /**
     * Return Users in Company
     *
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Required for adding new user to Company
     * to avoid some issues
     *
     * @param User $user
     * @return Company
     */
    public function setUsers(User $user)
    {
        return $this->addUser($user);
    }

    /**
     * Add new user to the Company
     *
     * @param User $user
     * @return Company
     */
    public function addUser(User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user from Company
     *
     * @param User $user
     * @return Company
     */
    public function removeUser(User $user)
    {
        $this->users->removeElement($user);

        return $this;
    }

    /**
     * Get company Access Roles
     *
     * @return ArrayCollection
     */
    public function getCompanyRoles()
    {
        return $this->companyRoles;
    }

    /**
     * Add new Access Roles to company
     *
     * @param AccessRole $companyRoles
     * @return Company
     */
    public function addCompanyRoles(AccessRole $companyRoles)
    {
        $this->companyRoles[] = $companyRoles;

        return $this;
    }

    /**
     * Remove given Access Roles from company
     *
     * @param AccessRole $companyRoles
     * @return Company
     */
    public function removeCompanyRoles(AccessRole $companyRoles)
    {
        $this->companyRoles->removeElement($companyRoles);

        return $this;
    }

    /**
     * Check if given user have access to the company
     *
     * @param User $user
     * @return bool
     */
    public function checkUserAccess(User $user)
    {
        $access = false;

        foreach ($this->users as $companyUser) {
            if ($companyUser->getId() == $user->getId()) {
                return true;
            }
        }

        return $access;
    }
}
