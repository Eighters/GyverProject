<?php

namespace GP\CoreBundle\Services;

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
    protected $kernelEnvironment;

    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating, $senderEmail, $kernelEnvironment)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->senderEmail = $senderEmail;
        $this->kernelEnvironment = $kernelEnvironment;
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
        $to = 'gauvin.thibaut83@gmail.com';
        $subject = $this->setSubjectPrefix() . '[GyverProject Notification] Account Deleted !';
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
        $to = 'gauvin.thibaut83@gmail.com';
        $subject = $this->setSubjectPrefix() . '[GyverProject Notification] Account Archived !';
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
        $to = 'gauvin.thibaut83@gmail.com';
        $subject = $this->setSubjectPrefix() . '[GyverProject Notification] Account Reactivated !';
        $body = $this->templating->render($template, array('user' => $user));

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
        return $this->kernelEnvironment == 'prod' ? '[PROD]' : '[DEV]';
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
            ->addBcc('arkezis@hotmail.fr')
            ->setSubject($subject)
            ->setBody($body)
            ->setContentType('text/html');

        $this->mailer->send($mail);
    }
}
