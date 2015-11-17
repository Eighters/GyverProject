<?php

namespace GyverBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var boolean
     *
     * @ORM\Column(name="civility", type="boolean")
     *
     * @Assert\NotNull()
     */
    private $civility;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=80)
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 80,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=80)
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 80,
     *      minMessage = "Your last name must be at least {{ limit }} characters long",
     *      maxMessage = "Your last name cannot be longer than {{ limit }} characters"
     * )
     */
    private $lastName;

    /**
     * @ORM\OneToMany(targetEntity="PhoneNumber", mappedBy="user")
     */
    private $phoneNumber;

    /**
     * @ORM\OneToMany(targetEntity="Email", mappedBy="user")
     */
    protected $emailList;

    /**
     * @ORM\ManyToMany(targetEntity="Company", cascade={"persist"})
     */
    private $company;

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
     * Add company
     *
     * @param \GyverBundle\Entity\company $company
     *
     * @return User
     */
    public function addCompany(\GyverBundle\Entity\Company $company)
    {
        $this->company[] = $company;

        return $this;
    }

    /**
     * Remove company
     *
     * @param \GyverBundle\Entity\Company $company
     */
    public function removeCompany(\GyverBundle\Entity\Company $company)
    {
        $this->company->removeElement($company);
    }

    /**
     * Get company
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set civility
     *
     * @param boolean $civility
     *
     * @return User
     */
    public function setCivility($civility)
    {
        $this->civility = $civility;

        return $this;
    }

    /**
     * Get civility
     *
     * @return boolean
     */
    public function getCivility()
    {
        return $this->civility;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }
}
