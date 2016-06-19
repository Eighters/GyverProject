<?php

namespace GP\SecurityBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use GP\CoreBundle\Tests\BaseTestCase;
/**
 * Unit testing for the Password controller
 *
 * @package GP\SecurityBundle\Tests\Controller
 */
class ResettingControllerTest extends BaseTestCase
{
    /**
     * Test valid request change password
     */
    public function testSubmitRequestChangePassword()
    {
        $client = static::createClient();
        $client->enableProfiler();

        $url = $this->generateRoute('fos_user_resetting_request');
        $crawler = $client->request('GET', $url);

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'A non logged user should see the request change password page');

        $form = $crawler->selectButton('_submit')->form(array('username'  => static::USER_CHEF_PROJET));
        $client->submit($form);

        // Check that an email was sent
        $mailCollector = $client->getProfile()->getCollector('swiftmailer');
        $this->assertEquals(1, $mailCollector->getMessageCount());

        // Asserting email data
        $collectedMessages = $mailCollector->getMessages();
        $message = $collectedMessages[0];
        $this->assertInstanceOf('Swift_Message', $message);
        $this->assertEquals('['.$this->getApplicationName().' Project] | Demande de réinitialisation de mot de passe', $message->getSubject());
        $this->assertEquals($client->getKernel()->getContainer()->getParameter('notification_sender_mail'), key($message->getFrom()));
        $this->assertEquals(static::USER_CHEF_PROJET, key($message->getTo()));

        $crawler = $client->followRedirect();

        // Assert Html contain success message
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertHtmlContains(
            $crawler,
            'Nous vous avons envoyé un email avec un lien pour réinitialiser votre mot de passe, Vérifiez vos email',
            'User should see a confirmation flashMessage when her request for a new password his saved'
        );

        // Assert valid DB user data
        $user = $this->getUserByEmail(static::USER_CHEF_PROJET);
        $this->assertRegExp(
            '^(19|20)\d\d[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])^',
            $user->getPasswordRequestedAt()->format('Y-m-d'),
            'A user who have submit valid reset password request should have her PasswordRequestedAt property to a valid DateTime format'
        );
    }

    /**
     * Test that a user cannot ask a other reset password demand
     *
     * @depends testSubmitRequestChangePassword
     */
    public function testInvalidSubmitRequestChangePassword()
    {
        $client = static::createClient();
        $client->enableProfiler();

        $url = $this->generateRoute('fos_user_resetting_request');
        $crawler = $client->request('GET', $url);

        $form = $crawler->selectButton('_submit')->form(array('username'  => static::USER_CHEF_PROJET));
        $crawler = $client->submit($form);

        // Check that an email not sent
        $mailCollector = $client->getProfile()->getCollector('swiftmailer');
        $this->assertEquals(0, $mailCollector->getMessageCount());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertHtmlContains(
            $crawler,
            'Erreur, Vous avez déjà une demande de réinitialisation de mot de passe en cours',
            'User should see a error flashMessage when he request reset password again'
        );
    }

    /**
     * After request password change, change the user password
     *
     * @depends testSubmitRequestChangePassword
     */
    public function testChangePassword()
    {
        $client = static::createClient();

        $user = $this->getUserByEmail(static::USER_CHEF_PROJET);
        $url = $this->generateRoute('reset_password', array('token' => $user->getConfirmationToken()));
        $crawler = $client->request('GET', $url);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $data = array(
            'fos_user_resetting_form[plainPassword][first]'  => 'tutu',
            'fos_user_resetting_form[plainPassword][second]'  => 'toto'
        );

        $form = $crawler->selectButton('_submit')->form($data);
        $crawler = $client->submit($form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertHtmlContains(
            $crawler,
            'Les mots de passe ne sont pas identiques',
            'User should see a error flashMessage when he submit two password that did not match'
        );

        $data = array(
            'fos_user_resetting_form[plainPassword][first]'  => 'tutu',
            'fos_user_resetting_form[plainPassword][second]'  => 'tutu'
        );

        $form = $crawler->selectButton('_submit')->form($data);
        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertHtmlContains(
            $crawler,
            'Votre mot de passe a bien été mis à jour',
            'User should see a confirmation flashMessage when he successfully change her password'
        );
    }
}
