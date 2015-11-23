<?php

namespace GyverBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Email
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="GyverBundle\Repository\EmailRepository")
 */
class Email
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
     * @ORM\ManyToOne(targetEntity="GyverBundle\Entity\User", inversedBy="emailList", cascade = {"persist"})
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     *
     * @Assert\NotNull()
     * @Assert\Email(
     *      message = "The email '{{ value }}' is not a valid email.",
     *      checkMX = true
     * )
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="principal", type="boolean")
     *
     * @Assert\NotNull()
     */
    private $principal;


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
     * Set email
     *
     * @param string $email
     *
     * @return Email
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set principal
     *
     * @param boolean $principal
     *
     * @return Email
     */
    public function setPrincipal($principal)
    {
        $this->principal = $principal;

        return $this;
    }

    /**
     * Get principal
     *
     * @return boolean
     */
    public function getPrincipal()
    {
        return $this->principal;
    }

    /**
     * Set user
     *
     * @param \GyverBundle\Entity\User $user
     *
     * @return Email
     */
    public function setUser(\GyverBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \GyverBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}