<?php

namespace GyverBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PhoneNumber
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class PhoneNumber
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
     * @ORM\ManyToOne(targetEntity="GyverBundle\Entity\User", inversedBy="phoneNumber", cascade = {"persist"})
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="phoneNumber", type="string")
     */
    private $phoneNumber;

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
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }


}
