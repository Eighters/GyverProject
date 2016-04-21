<?php

namespace GP\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Company
 *
 * @ORM\Table(name="company")
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
     *
     */
    private $name;

    /**
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
     *
     */
    private $description;

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
     * @return Company
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
}
