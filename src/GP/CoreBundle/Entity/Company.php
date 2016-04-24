<?php

namespace GP\CoreBundle\Entity;

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
     * Company constructor.
     */
    public function __construct()
    {
        $this->creationDate = new \DateTime("now");
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
}
