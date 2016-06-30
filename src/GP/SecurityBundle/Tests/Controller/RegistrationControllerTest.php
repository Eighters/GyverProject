<?php

namespace GP\SecurityBundle\Tests\Controller;

use GP\CoreBundle\Entity\Invitation;
use GP\CoreBundle\Tests\BaseTestCase;

/**
 * Unit testing for the Registration controller
 *
 * @package GP\SecurityBundle\Tests\Controller
 */
class RegistrationControllerTest extends BaseTestCase
{
    /**
     * Test that only a invited user have access to the registration form
     * User should follow link in her Invitation Email, who contain a security token for registration
     *
     * @dataProvider userProvider
     * @param $invitationEmail
     * @param $expectedStatusCode
     * @param $message
     */
    public function testRegistrationAccessForm($invitationEmail, $expectedStatusCode, $message)
    {
        $client = static::createClient();

        $em = $client->getContainer()->get('doctrine')->getManager();
        /** @var Invitation $invitation */
        $invitation = $em->getRepository('GPCoreBundle:Invitation')->findOneByEmail($invitationEmail);

        // They are no invitation found for 'invalid-email@test.fr'
        if (!$invitation) {
            // We set a fake token to test invalid access
            $invitation = new Invitation();
            $invitation->setConfirmationToken('toto');
        }

        $url = $this->generateRoute('register', array('token' => $invitation->getConfirmationToken()));
        $client->request('GET', $url);

        $this->assertStatusCode($expectedStatusCode, $client, $message);
    }

    public function userProvider()
    {
        return array (
            array(
                'invitationEmail' => self::INVITATION_EMAIL,
                'expectedStatusCode' => '200',
                'message' => 'An invited user should see the registration page',
            ),
            array(
                'invitationEmail' => 'invalid-email@test.fr',
                'expectedStatusCode' => '404',
                'message' => 'An NON invited User should NOT see the registration page',
            ),
        );
    }

    /**
     * Test errors on registration form
     */
    public function testInvalidRegistrationForm()
    {
        $client = static::createClient();

        $em = $client->getContainer()->get('doctrine')->getManager();
        /** @var Invitation $invitation */
        $invitation = $em->getRepository('GPCoreBundle:Invitation')->findOneByEmail(self::INVITATION_EMAIL);

        $url = $this->generateRoute('register', array('token' => $invitation->getConfirmationToken()));
        $crawler = $client->request('GET', $url);

        $this->assertStatusCode(200, $client, 'An invited user should see the registration page');
        $form = $crawler->selectButton('_submit')->form();

        $crawler = $client->submit($form, array(
            "fos_user_registration_form[plainPassword][first]" => 'toto',
            "fos_user_registration_form[plainPassword][second]" => 'tutu',
        ));

        $this->assertStatusCode(200, $client);

        $this->assertHtmlContains(
            $crawler,
            "fos_user.password.mismatch",
            'User should see a error message when he submit invalid sign up form (password mismatch)'
        );
    }

    /**
     * Create invitation for test
     */
    public function testSuccessInviteUserAction()
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);

        $url = $this->generateRoute('admin_invitation_new');
        $crawler = $client->request('GET', $url);
        $this->assertStatusCode(200, $client);

        $form = $crawler->selectButton('_submit')->form();

        $form["send_invitation[civility]"]->select('male');

        $mail = "test-invitation@test.fr";
        $client->submit($form, array(
            "send_invitation[email]" => $mail,
            "send_invitation[userName]" => "Super Toto",
            "send_invitation[firstName]" => "toto",
            "send_invitation[lastName]" => "tutullu"
        ));

        $this->assertRedirectTo($client, 'admin_show_all_user');
        $crawler = $client->followRedirect();

        $this->assertStatusCode(200, $client);

        $this->assertFlashMessageContains(
            $crawler,
            "Une invitation a été envoyée à l'adresse: " . $mail,
            'Admin should see confirmation flashMessage when he invite new user in application'
        );

        return $mail;
    }

    /**
     * Test submit a valid registration form, who sign up new account in application
     *
     * @depends testSuccessInviteUserAction
     * @param $invitationMail
     */
    public function testValidRegistrationForm($invitationMail)
    {
        $client = static::createClient();

        $em = $client->getContainer()->get('doctrine')->getManager();
        /** @var Invitation $invitation */
        $invitation = $em->getRepository('GPCoreBundle:Invitation')->findOneByEmail($invitationMail);

        $url = $this->generateRoute('register', array('token' => $invitation->getConfirmationToken()));
        $crawler = $client->request('GET', $url);

        $this->assertStatusCode(200, $client, 'An invited user should see the registration page');
        $form = $crawler->selectButton('_submit')->form();

        $client->submit($form, array(
            "fos_user_registration_form[plainPassword][first]" => 'toto',
            "fos_user_registration_form[plainPassword][second]" => 'toto',
        ));

        $this->assertRedirectTo($client, 'login');
        $client->followRedirect();

        $this->assertRedirectTo($client, 'dashboard');
        $crawler = $client->followRedirect();

        $this->assertStatusCode(200, $client);

        $this->assertFlashMessageContains(
            $crawler,
            "Votre compte a bien été créé",
            'User should see a confirmation message when he successfully sign up new account'
        );

        $this->assertFlashMessageContains(
            $crawler,
            "registration.flash.user_created",
            'User should see a confirmation message when he successfully sign up new account'
        );

        return $invitationMail;
    }

    /**
     * Remove invited user & invitation used for
     *
     * @depends testValidRegistrationForm
     * @param $invitationMail
     */
    public function testCleanDataBase($invitationMail)
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);

        $invitedUser = $this->getUserByEmail($invitationMail);
        $this->em->remove($invitedUser);
        $this->em->flush();

        $em = $client->getContainer()->get('doctrine')->getManager();
        /** @var Invitation $invitation */
        $invitation = $em->getRepository('GPCoreBundle:Invitation')->findOneByEmail($invitationMail);

        $url = $this->generateRoute('admin_delete_invitation', array('id' => $invitation->getCode()));
        $client->request('GET', $url);

        $this->assertRedirectTo($client, 'admin_show_invitation');
        $crawler = $client->followRedirect();

        $this->assertFlashMessageContains(
            $crawler,
            "L'invitation " . $invitation->getCode() . " a été correctement supprimée",
            'Admin should see confirmation flashMessage when he successfully delete a invitation'
        );
    }
}
