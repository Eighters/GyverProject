<?php

namespace GP\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ProjectCategory
 *
 * @ORM\Table()
 * @ORM\Entity
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
     */
    private $name;

    /**
     * @var Company
     *
     * @ORM\ManyToOne(targetEntity="GP\CoreBundle\Entity\Company", inversedBy="projectCategory")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    private $company;

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
     * @return integer
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set company
     *
     * @param integer $company
     * @return ProjectCategory
     */
    public function setCompany($company)
    {
        $this->company = $company;

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
