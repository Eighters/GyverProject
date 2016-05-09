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
     *      min = 1,
     *      max = 255,
     *      minMessage = "Company name must be at least {{ limit }} characters long",
     *      maxMessage = "Company name cannot be longer than {{ limit }} characters"
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
     *      min = 1,
     *      max = 5000,
     *      minMessage = "Company description must be at least {{ limit }} characters long",
     *      maxMessage = "Company description cannot be longer than {{ limit }} characters"
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
     * @ORM\OneToMany(targetEntity="GP\CoreBundle\Entity\ProjectCategory", mappedBy="company", cascade={"persist"})
     */
    private $projectCategory;

    /**
     * A collection of user associated to the project
     *
     * @var User
     *
     * @ORM\ManyToMany(targetEntity="GP\CoreBundle\Entity\User", mappedBy="companies")
     */
    private $users;

    /**
     * Registered role for the Company
     *
     * @var AccessRole
     *
     * @ORM\OneToMany(targetEntity="GP\CoreBundle\Entity\AccessRole", mappedBy="company")
     */
    private $companyRoles;

    /**
     * Company constructor.
     */
    public function __construct()
    {
        $this->creationDate = new \DateTime("now");
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
     * Return Users in Company
     *
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add new user to the Company
     *
     * @param User $user
     *
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
     *
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
