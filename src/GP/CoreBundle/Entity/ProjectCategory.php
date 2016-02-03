<?php

namespace GP\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\OneToMany(targetEntity="GP\CoreBundle\Entity\Company", mappedBy="id", cascade={"persist"})
     */
    private $company;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_global", type="boolean")
     */
    private $isGlobal;


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
     * Set name
     *
     * @param string $name
     *
     * @return ProjectCategory
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * Set company
     *
     * @param integer $company
     *
     * @return ProjectCategory
     */
    public function setCompany($company)
    {
        $this->company = $company;

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
     * @return boolean
     */
    public function isIsGlobal()
    {
        return $this->isGlobal;
    }

    /**
     * @param boolean $isGlobal
     */
    public function setIsGlobal($isGlobal)
    {
        $this->isGlobal = $isGlobal;
    }
}

