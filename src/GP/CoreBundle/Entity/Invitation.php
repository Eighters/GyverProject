<?php

namespace GP\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * This class is used to invite new user in the application
 *
 * Class Invitation
 *
 * @ORM\Table(name="invitation")
 * @ORM\Entity(repositoryClass="GP\CoreBundle\Repository\InvitationRepository")
 *
 * @package GP\CoreBundle\Entity
 */
class Invitation
{
    /**
     * @ORM\Id @ORM\Column(name="code", type="string", length=6)
     */
    protected $code;

    /**
     * @ORM\Column(name="email", type="string", length=256)
     *
     * @Assert\NotNull(message="Vous devez renseigner une adresse Email")
     * @Assert\Email(message = "'{{ value }}' n'est pas un Email valide")
     */
    protected $email;

    /**
     * When sending invitation this value is set to `true`
     * It can prevent invitations from being sent twice
     *
     * @ORM\Column(name="is_sent", type="boolean")
     */
    protected $sent = false;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="sent_at", type="datetime")
     */
    protected $sentAt;

    /**
     * @var string
     *
     * @ORM\Column(name="welcome_message", type="text", length=5000)
     *
     * @Assert\NotNull(message="Vous devez renseigner un message de bienvenue")
     * @Assert\Length(
     *      min = 2,
     *      max = 2000,
     *      minMessage = "Votre message de bienvenue doit avoir un minimum de {{ limit }} caractères",
     *      maxMessage = "Votre message de bienvenue ne peut pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $welcomeMessage;

    public function __construct()
    {
        $this->code = substr(md5(uniqid(rand(), true)), 0, 6);
        $this->sentAt = new \DateTime("now");
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function isSent()
    {
        return $this->sent;
    }

    public function send()
    {
        $this->sent = true;
    }

    /**
     * @return DateTime
     */
    public function getSentAt()
    {
        return $this->sentAt;
    }

    /**
     * @param DateTime $sentAt
     */
    public function setSentAt($sentAt)
    {
        $this->sentAt = $sentAt;
    }

    /**
     * @return string
     */
    public function getWelcomeMessage()
    {
        return $this->welcomeMessage;
    }

    /**
     * @param string $welcomeMessage
     */
    public function setWelcomeMessage($welcomeMessage)
    {
        $this->welcomeMessage = $welcomeMessage;
    }
}
