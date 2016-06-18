<?php

namespace GP\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AccessRole
 *
 * The Access Role in application :
 * Access role for company (company_id & user_id)
 * Access role for project (project_id & user_id)
 *
 * @ORM\Table(name="access_role")
 * @ORM\Entity(repositoryClass="GP\CoreBundle\Repository\AccessRoleRepository")
 */
class AccessRole
{
    CONST TYPE_PROJECT = 'project';
    CONST TYPE_COMPANY = 'company';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * The Access Role type :
     * Is an Access Role for a Company or a Project ?
     *
     * Use constant self::COMPANY or self::PROJECT
     *
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank(message="Vous devez spécifiez un type de rôle")
     */
    private $type;

    /**
     * The Access Role name
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank(message="Vous devez spécifiez un nom de rôle")
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "Le nom de rôle doit faire un minimum de {{ limit }} caractères",
     *      maxMessage = "Le nom de rôle ne peut excéder {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     * The Access Role description
     *
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000, nullable=false)
     *
     * @Assert\NotBlank(message="Vous devez spécifiez un description de rôle")
     * @Assert\Length(
     *      min = 3,
     *      max = 5000,
     *      minMessage = "La description du rôle doit faire un minimum de {{ limit }} caractères",
     *      maxMessage = "La description du rôle ne peut excéder {{ limit }} caractères"
     * )
     */
    private $description;

    /**
     * The user associated to the Access Role
     *
     * @var User
     *
     * @ORM\ManyToMany(targetEntity="GP\CoreBundle\Entity\User", mappedBy="accessRole")
     */
    private $users;

    /**
     * The company associated to the Access Role
     * Only if type = company
     *
     * @var Company
     *
     * @ORM\ManyToOne(targetEntity="GP\CoreBundle\Entity\Company", inversedBy="companyRoles", cascade={"remove"})
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    private $company;

    /**
     * The project associated to the Access Role
     * Only if type = project
     *
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="GP\CoreBundle\Entity\Project", inversedBy="projectRoles", cascade={"remove"})
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    private $project;

    /**
     * Role constructor
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
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
     * Get Access Role Type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set Access Role Type
     *
     * @param string $type
     * @return AccessRole
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get Access Role Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Access Role Name
     *
     * @param string $name
     * @return AccessRole
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Access Role Description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set Access Role Description
     *
     * @param string $description
     * @return AccessRole
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get user Access Role
     *
     * @return User
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add Users to Access Role
     *
     * @param User $user
     * @return AccessRole
     */
    public function addUsers($user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove Users from Access Role
     *
     * @param User $user
     * @return AccessRole
     */
    public function removeUsers(User $user)
    {
        $this->users->removeElement($user);

        return $this;
    }

    /**
     * Get Access Role Company
     *
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set Access Role Company
     *
     * @param Company $company
     * @return AccessRole
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get Access Role project
     *
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set Access Role project
     *
     * @param Project $project
     * @return AccessRole
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }
}
