<?php

namespace GP\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * This class is used to invite new user in the application
 *
 * Class Invitation
 *
 * @ORM\Table(name="invitation")
 * @ORM\Entity()
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
}
