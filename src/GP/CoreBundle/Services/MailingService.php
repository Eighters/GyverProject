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

    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating, $senderEmail)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->senderEmail = $senderEmail;
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
        $subject = '[GyverProject Notification] Account Deleted !';
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
        $subject = '[GyverProject Notification] Account Archived !';
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
        $subject = '[GyverProject Notification] Account Reactivated !';
        $body = $this->templating->render($template, array('user' => $user));

        $this->sendMessage($from, $to, $subject, $body);
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
            ->setSubject($subject)
            ->setBody($body)
            ->setContentType('text/html');

        $this->mailer->send($mail);
    }
}
