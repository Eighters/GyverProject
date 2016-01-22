<?php

namespace GP\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

use GP\CoreBundle\Entity\Email;
use GP\CoreBundle\Entity\Phone;
use GP\CoreBundle\Entity\Company;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="GP\CoreBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * Call the FOSUserBundle constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var enum $civility
     *
     * @ORM\Column(name="civility", type="string", columnDefinition="enum('male', 'female')")
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
     * @ORM\OneToMany(targetEntity="GP\CoreBundle\Entity\Phone", mappedBy="user", cascade={"remove"})
     */
    private $phoneList;

    /**
     * @ORM\OneToMany(targetEntity="GP\CoreBundle\Entity\Email", mappedBy="user", cascade={"remove"})
     */
    protected $emailList;

    /**
     * @ORM\ManyToMany(targetEntity="GP\CoreBundle\Entity\Company", cascade={"persist"})
     */
    private $company;

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
     * Set civility
     *
     * @param string $civility
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
     * @return string
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

    /**
     * Add phoneList
     *
     * @param Phone $phoneList
     *
     * @return User
     */
    public function addPhoneList(Phone $phoneList)
    {
        $this->phoneList[] = $phoneList;

        return $this;
    }

    /**
     * Remove phoneList
     *
     * @param Phone $phoneList
     */
    public function removePhoneList(Phone $phoneList)
    {
        $this->phoneList->removeElement($phoneList);
    }

    /**
     * Get phoneList
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhoneList()
    {
        return $this->phoneList;
    }

    /**
     * Add emailList
     *
     * @param Email $emailList
     *
     * @return User
     */
    public function addEmailList(Email $emailList)
    {
        $this->emailList[] = $emailList;

        return $this;
    }

    /**
     * Remove emailList
     *
     * @param Email $emailList
     */
    public function removeEmailList(Email $emailList)
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
     * @param Company $company
     *
     * @return User
     */
    public function addCompany(Company $company)
    {
        $this->company[] = $company;

        return $this;
    }

    /**
     * Remove company
     *
     * @param Company $company
     */
    public function removeCompany(Company $company)
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
}
