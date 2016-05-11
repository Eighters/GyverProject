<?php

namespace GP\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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

        $this->companies = new ArrayCollection();
        $this->accessRole = new ArrayCollection();
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
     * The invitation used to register the user
     *
     * @var Invitation
     *
     * @ORM\OneToOne(targetEntity="GP\CoreBundle\Entity\Invitation")
     * @ORM\JoinColumn(referencedColumnName="code")
     */
    protected $invitation;

    /**
     * The user civility
     *
     * @var string $civility
     *
     * @ORM\Column(name="civility", type="string", length=10)
     */
    private $civility;

    /**
     * The user first name
     *
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=80)
     *
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
     * The user last name
     *
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=80)
     *
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
     * User phone numbers
     *
     * @ORM\OneToMany(targetEntity="GP\CoreBundle\Entity\Phone", mappedBy="user", cascade={"remove"})
     */
    private $phoneList;

    /**
     * User Emails addresses
     *
     * @ORM\OneToMany(targetEntity="GP\CoreBundle\Entity\Email", mappedBy="user", cascade={"remove"})
     */
    protected $emailList;

    /**
     * A collection of user associated companies
     *
     * @var Company
     *
     * @ORM\ManyToMany(targetEntity="GP\CoreBundle\Entity\Company", inversedBy="users")
     * @ORM\JoinTable(name="company_users")
     */
    private $companies;

    /**
     * Registered role for the user
     *
     * @var AccessRole
     *
     * @ORM\ManyToMany(targetEntity="GP\CoreBundle\Entity\AccessRole", inversedBy="users")
     * @ORM\JoinTable(name="user_access")
     */
    private $accessRole;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function getInvitation()
    {
        return $this->invitation;
    }

    /**
     * Set Invitation
     *
     * @param Invitation $invitation
     * @return User
     */
    public function setInvitation(Invitation $invitation)
    {
        $this->invitation = $invitation;

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
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
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
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
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
        $this->companies[] = $company;

        return $this;
    }

    /**
     * Remove company
     *
     * @param Company $company
     *
     * @return User
     */
    public function removeCompany(Company $company)
    {
        $this->companies->removeElement($company);

        return $this;
    }

    /**
     * Get company
     *
     * @return ArrayCollection
     */
    public function getCompany()
    {
        return $this->companies;
    }

    ####################################################################
    # TA MERE LA PUTA MADRES DE CON DE CHIOTTE !! :O
    ####################################################################

    /**
     * Add new Access Role to user
     *
     * @param AccessRole $accessRole
     *
     * @return User
     */
    public function addAccessRole(AccessRole $accessRole)
    {
        $this->accessRole[] = $accessRole;

        return $this;
    }

    /**
     * Remove given Access Role to User
     *
     * @param AccessRole $accessRole
     *
     * @return User
     */
    public function removeAccessRole(AccessRole $accessRole)
    {
        $this->accessRole->removeElement($accessRole);

        return $this;
    }

    /**
     * Get User Access Role
     *
     * @return ArrayCollection
     */
    public function getAccessRole()
    {
        return $this->accessRole;
    }
}
