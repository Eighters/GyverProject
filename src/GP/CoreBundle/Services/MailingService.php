<?php

namespace GP\CoreBundle\Services;

use GP\CoreBundle\Entity\Invitation;
use Symfony\Component\Templating\EngineInterface;
use GP\CoreBundle\Entity\User;

/**
 * Class MailingService
 * @package GP\CoreBundle\Services
 */
class MailingService
{
    protected $mailer;
    protected $templating;
    protected $senderEmail;
    protected $bccEmail;
    protected $kernelEnvironment;
    protected $applicationName;

    /**
     * MailingService constructor.
     * @param \Swift_Mailer $mailer
     * @param EngineInterface $templating
     * @param $senderEmail
     * @param $bccEmail
     * @param $kernelEnvironment
     * @param $applicationName
     */
    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating, $senderEmail, $bccEmail, $kernelEnvironment, $applicationName)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->senderEmail = $senderEmail;
        $this->bccEmail = $bccEmail;
        $this->kernelEnvironment = $kernelEnvironment;
        $this->applicationName = $applicationName;
    }

    /**
     * Send an email to the user when her account is DELETED
     *
     * @param User $user
     */
    public function sendUserAccountDeletedNotification(User $user)
    {
        $template = ':Email:account_deleted.html.twig';

        $from = $this->senderEmail;
        $to = $user->getEmail();
        $subject = $this->setSubjectPrefix() . 'Account Deleted !';
        $body = $this->templating->render($template, array('user' => $user));

        $this->sendMessage($from, $to, $subject, $body);
    }

    /**
     * Send an email to the user when her account is ARCHIVED
     *
     * @param User $user
     */
    public function sendUserAccountArchivedNotification(User $user)
    {
        $template = ':Email:account_archived.html.twig';

        $from = $this->senderEmail;
        $to = $user->getEmail();
        $subject = $this->setSubjectPrefix() . 'Account Archived !';
        $body = $this->templating->render($template, array('user' => $user));

        $this->sendMessage($from, $to, $subject, $body);
    }

    /**
     * Send an email to the user when her account is ACTIVATED
     *
     * @param User $user
     */
    public function sendUserAccountActivatedNotification(User $user)
    {
        $template = ':Email:account_activated.html.twig';

        $from = $this->senderEmail;
        $to = $user->getEmail();
        $subject = $this->setSubjectPrefix() . 'Account Reactivated !';
        $body = $this->templating->render($template, array('user' => $user));

        $this->sendMessage($from, $to, $subject, $body);
    }

    /**
     * Send an Invitation email to the given user email adress
     *
     * @param Invitation $invitation
     */
    public function sendUserInvitationNotification(Invitation $invitation)
    {
        $template = ':Email:user_invitation.html.twig';

        $from = $this->senderEmail;
        $to = $invitation->getEmail();
        $subject = $this->setSubjectPrefix() . 'Codes Inscription';
        $body = $this->templating->render($template, array('invitation' => $invitation));

        $this->sendMessage($from, $to, $subject, $body);
    }

    /**
     * Set the prefix of the mail subject
     * It depend on kernel environment & it can be :
     * [DEV] or [PROD]
     *
     * @return string
     */
    private function setSubjectPrefix() {
        $envPrefix = $this->kernelEnvironment == 'prod' ? '[PROD]' : '[DEV]';
        return $envPrefix . ' ['.$this->applicationName.' Project] ';
    }

    /**
     * Send the given message using SwiftMailer library
     *
     * @param $from
     * @param $to
     * @param $subject
     * @param $body
     */
    protected function sendMessage($from, $to, $subject, $body)
    {
        $mail = \Swift_Message::newInstance();

        $mail
            ->setFrom($from)
            ->setTo($to)
            ->addBcc($this->bccEmail)
            ->setSubject($subject)
            ->setBody($body)
            ->setContentType('text/html');

        $this->mailer->send($mail);
    }
}
