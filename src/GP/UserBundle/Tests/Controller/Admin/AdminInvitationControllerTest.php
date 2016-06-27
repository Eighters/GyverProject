<?php

namespace GP\UserBundle\Tests\Controller;

use GP\CoreBundle\Entity\Invitation;
use GP\CoreBundle\Tests\BaseTestCase;

/**
 * Unit testing for the Admin Invitation Controller
 *
 * @package GP\UserBundle\Tests\Controller\Admin
 */
class AdminInvitationControllerTest extends BaseTestCase
{
    /**
     * Test only admin can access to user invitation list page
     *
     * @dataProvider userProvider
     *
     * @param $userName
     * @param $password
     * @param $expectedStatusCode
     * @param $message
     */
    public function testAccessShowInvitationAction($userName, $password, $expectedStatusCode, $message)
    {
        $client = $this->connectUser($userName, $password);
        $url = $this->generateRoute('admin_show_invitation');
        $client->request('GET', $url);

        $this->assertEquals($expectedStatusCode, $client->getResponse()->getStatusCode(), $message);
    }

    /**
     * Test only admin can create a create new invitation
     *
     * @dataProvider userProvider
     *
     * @param $userName
     * @param $password
     * @param $expectedStatusCode
     * @param $message
     */
    public function testAccessInviteUserAction($userName, $password, $expectedStatusCode, $message)
    {
        $client = $this->connectUser($userName, $password);
        $url = $this->generateRoute('admin_invitation_new');
        $client->request('GET', $url);

        $this->assertEquals($expectedStatusCode, $client->getResponse()->getStatusCode(), $message);
    }

    public function userProvider()
    {
        return array (
            array(
                'userName' => self::USER_ADMIN,
                'password' => self::USER_PASSWORD,
                'expectedStatusCode' => '200',
                'message' => 'An admin User should see the user invitation list',
            ),
            array(
                'userName' => self::USER_DEVELOPPEUR,
                'password' => self::USER_PASSWORD,
                'expectedStatusCode' => '403',
                'message' => 'An NON admin User should NOT see the user invitation list',
            ),
        );
    }

    /**
     * Test errors on user invitation form
     *
     * @dataProvider invitationProvider
     * @param $data
     * @param $errors
     */
    public function testInvalidInviteUserAction($data, $errors)
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);

        $url = $this->generateRoute('admin_invitation_new');
        $crawler = $client->request('GET', $url);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('_submit')->form();
        $form["send_invitation[civility]"]->select('male');

        $crawler = $client->submit($form, $data);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        foreach ($errors as $errorName => $errorMessage) {
            $this->assertHtmlContains($crawler, $errorMessage, "Invalid error message for " . $errorName . " in invitation form");
        }
    }

    public function invitationProvider()
    {
        return array (
            array (
                'form' => array(
                    "send_invitation[email]" => "",
                    "send_invitation[userName]" => "",
                    "send_invitation[firstName]" => "",
                    "send_invitation[lastName]" => ""
                ),
                'error' => array(
                    'email' => "Vous devez renseigner une adresse Email",
                    'userName' => "Vous devez renseigner un pseudo",
                    'firstName' => "Vous devez renseigner un Prénom",
                    'lastName' => "Vous devez renseigner un Nom",
                )
            ),
            array (
                'form' => array(
                    "send_invitation[email]" => "toto",
                    "send_invitation[userName]" => "t",
                    "send_invitation[firstName]" => "t",
                    "send_invitation[lastName]" => "t"
                ),
                'error' => array(
                    'email' => "\"toto\"' n'est pas un Email valide",
                    'userName' => "Le pseudo doit avoir un minimum de 2 caractères",
                    'firstName' => "Le Prénom doit avoir un minimum de 2 caractères",
                    'lastName' => "Le Nom doit avoir un minimum de 2 caractères",
                )
            ),
            array (
                'form' => array(
                    "send_invitation[email]" => "",
                    "send_invitation[userName]" => str_repeat("a", 81),
                    "send_invitation[firstName]" => str_repeat("a", 81),
                    "send_invitation[lastName]" => str_repeat("a", 81)
                ),
                'error' => array(
                    'email' => "Vous devez renseigner une adresse Email",
                    'userName' => "Le pseudo ne peut pas faire plus de 80 caractères",
                    'firstName' => "Le Prénom ne peut pas faire plus de 80 caractères",
                    'lastName' => "Le Nom ne peut pas faire plus de 80 caractères",
                )
            ),
        );
    }

    /**
     * Test valid user invitation form
     */
    public function testSuccessInviteUserAction()
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);

        $url = $this->generateRoute('admin_invitation_new');
        $crawler = $client->request('GET', $url);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('_submit')->form();

        $form["send_invitation[civility]"]->select('male');

        $mail = "toto@hotmail.fr";
        $client->submit($form, array(
            "send_invitation[email]" => $mail,
            "send_invitation[userName]" => "Super Toto",
            "send_invitation[firstName]" => "toto",
            "send_invitation[lastName]" => "tutullu"
        ));

        $this->assertRedirectTo($client, 'admin_show_all_user');
        $crawler = $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertFlashMessageContains(
            $crawler,
            "Une invitation a été envoyée à l'adresse: " . $mail,
            'Admin should see confirmation flashMessage when he invite new user in application'
        );

        return $mail;
    }

    /**
     * Test admin can delete given User Invitation
     *
     * @depends testSuccessInviteUserAction
     * @param $mail
     */
    public function testSuccessDeleteInvitation($mail)
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);

        $em = $client->getContainer()->get('doctrine')->getManager();
        /** @var Invitation $invitation */
        $invitation = $em->getRepository('GPCoreBundle:Invitation')->findOneByEmail($mail);

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

    /**
     * Test admin can delete a not found User Invitation
     *
     * @depends testSuccessInviteUserAction
     */
    public function testFailDeleteInvitation()
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);

        $url = $this->generateRoute('admin_delete_invitation', array('id' => 'kkkkkk'));
        $client->request('GET', $url);

        $this->assertRedirectTo($client, 'admin_show_invitation');
        $crawler = $client->followRedirect();

        $this->assertFlashMessageContains(
            $crawler,
            "L'invitation est introuvable",
            'Admin should see error flashMessage when he delete a not found invitation'
        );
    }
}
