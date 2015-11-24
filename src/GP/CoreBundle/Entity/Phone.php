<?php

namespace GP\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use GP\CoreBundle\Entity\User;

/**
 * Phone
 *
 * @ORM\Table(name="phone")
 * @ORM\Entity(repositoryClass="GP\CoreBundle\Repository\PhoneRepository")
 */
class Phone
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
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="GP\CoreBundle\Entity\User", inversedBy="phoneList", cascade = {"persist"})
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=15)
     *
     * @Assert\NotNull()
     * @Assert\Length(
     *      min = 8,
     *      max = 15,
     *      minMessage = "Your phone number must be at least {{ limit }} characters long",
     *      maxMessage = "Your phone number cannot be longer than {{ limit }} characters"
     * )
     */
    private $number;

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
     * Set number
     *
     * @param string $number
     *
     * @return Phone
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return Phone
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
