<?php

namespace GP\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ProjectCategory
 *
 * @ORM\Table(name="project_category", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})})
 * @ORM\Entity(repositoryClass="GP\CoreBundle\Repository\ProjectCategoryRepository")
 */
class ProjectCategory
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
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @Assert\NotBlank(message="Veuillez spécifier un nom de catégorie projet")
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "Le nom de la catégorie projet doit faire un minimum de {{ limit }} caractères",
     *      maxMessage = "Le nom de la catégorie projet ne peut excéder {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     * @var Company
     *
     * @ORM\ManyToOne(targetEntity="GP\CoreBundle\Entity\Company", inversedBy="projectCategory", cascade={"persist"})
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    private $company;

    /**
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="GP\CoreBundle\Entity\Project", inversedBy="projectCategory", cascade={"persist"})
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    private $project;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_global", type="boolean")
     */
    private $global;

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
     * @return ProjectCategory
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get company
     *
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set company
     *
     * @param Company $company
     * @return ProjectCategory
     */
    public function setCompany(Company $company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get project
     *
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set project
     *
     * @param Project $project
     * @return ProjectCategory
     */
    public function setProject(Project $project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get global
     *
     * @return boolean
     */
    public function isGlobal()
    {
        return $this->global;
    }

    /**
     * Set global
     *
     * @param boolean $global
     * @return ProjectCategory
     */
    public function setGlobal($global)
    {
        $this->global = $global;

        return $this;
    }
}
