<?php

namespace GyverBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Entity(repositoryClass="GyverBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    public function __construct()
    {
        parent::__construct();
        $this->phonenumbers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="PhoneNumber", mappedBy="user")
     */
    private $phoneNumber;

    /**
     * @ORM\OneToMany(targetEntity="Email", mappedBy="user")
     */
    protected $emailList;

    /**
     * @ORM\ManyToMany(targetEntity="Compagny", cascade={"persist"})
     */
    private $compagny;

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phonenumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * Add phoneNumber
     *
     * @param \GyverBundle\Entity\PhoneNumber $phoneNumber
     *
     * @return User
     */
    public function addPhoneNumber(\GyverBundle\Entity\PhoneNumber $phoneNumber)
    {
        $this->phoneNumber[] = $phoneNumber;

        return $this;
    }

    /**
     * Remove phoneNumber
     *
     * @param \GyverBundle\Entity\PhoneNumber $phoneNumber
     */
    public function removePhoneNumber(\GyverBundle\Entity\PhoneNumber $phoneNumber)
    {
        $this->phoneNumber->removeElement($phoneNumber);
    }

    /**
     * Add email
     *
     * @param \GyverBundle\Entity\Email $email
     *
     * @return User
     */
    public function addEmail(\GyverBundle\Entity\Email $email)
    {
        $this->email[] = $email;

        return $this;
    }

    /**
     * Remove email
     *
     * @param \GyverBundle\Entity\Email $email
     */
    public function removeEmail(\GyverBundle\Entity\Email $email)
    {
        $this->email->removeElement($email);
    }

    /**
     * Add emailList
     *
     * @param \GyverBundle\Entity\Email $emailList
     *
     * @return User
     */
    public function addEmailList(\GyverBundle\Entity\Email $emailList)
    {
        $this->emailList[] = $emailList;

        return $this;
    }

    /**
     * Remove emailList
     *
     * @param \GyverBundle\Entity\Email $emailList
     */
    public function removeEmailList(\GyverBundle\Entity\Email $emailList)
    {
        $this->emailList->removeElement($emailList);
    }

    /**
     * Get emailList
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmailList()
    {
        return $this->emailList;
    }

    /**
     * Add compagny
     *
     * @param \GyverBundle\Entity\Compagny $compagny
     *
     * @return User
     */
    public function addCompagny(\GyverBundle\Entity\Compagny $compagny)
    {
        $this->compagny[] = $compagny;

        return $this;
    }

    /**
     * Remove compagny
     *
     * @param \GyverBundle\Entity\Compagny $compagny
     */
    public function removeCompagny(\GyverBundle\Entity\Compagny $compagny)
    {
        $this->compagny->removeElement($compagny);
    }

    /**
     * Get compagny
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompagny()
    {
        return $this->compagny;
    }
}
