<?php

namespace GP\UserBundle\Tests\Controller;

use GP\CoreBundle\Entity\User;
use GP\CoreBundle\Tests\BaseTestCase;

/**
 * Unit testing for the Dashboard controller
 *
 * @package GP\UserBundle\Tests\Controller\Admin
 */
class AdminUserControllerTest extends BaseTestCase
{
    /**
     * Test only admin can access admin dashboard page
     *
     * @dataProvider userProvider
     *
     * @param $userName
     * @param $password
     * @param $expectedStatusCode
     * @param $message
     */
    public function testIndexAction($userName, $password, $expectedStatusCode, $message)
    {
        $client = $this->connectUser($userName, $password);
        $url = $this->generateRoute('admin_dashboard');
        $client->request('GET', $url);

        $this->assertStatusCode($expectedStatusCode, $client, $message);
    }


    public function userProvider()
    {
        return array (
            array(
                'userName' => self::USER_ADMIN,
                'password' => self::USER_PASSWORD,
                'expectedStatusCode' => '200',
                'message' => 'An admin User should see the admin dashboard page',
            ),
            array(
                'userName' => self::USER_CHEF_PROJET,
                'password' => self::USER_PASSWORD,
                'expectedStatusCode' => '302',
                'message' => 'An NON admin User should NOT see the admin dashboard page',
            ),
        );
    }

    /**
     * Test that only admin can access Manage user page
     */
    public function testShowUsersAction()
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);
        $url = $this->generateRoute('admin_show_all_user');
        $crawler =  $client->request('GET', $url);

        $this->assertStatusCode(200, $client, 'An admin User should see the admin manage user page');

        $this->assertHtmlContains($crawler, 'Liste des Utilisateurs:', 'Admin should see the manage user page right title');

        $totalUser = $this->getTotalUser();
        $this->assertHtmlContains($crawler, 'Vous avez ' . $totalUser . ' Utilisateurs.', 'Admin should see ' . $totalUser . ' users listed in the manage user page');
    }

    /**
     * Test that only admin can access to a given user account summary page
     */
    public function testShowUserAction()
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);
        $user = $this->getUserByEmail(self::USER_CHEF_PROJET);
        $url = $this->generateRoute('admin_show_user', array('id' => $user->getId()));
        $crawler =  $client->request('GET', $url);

        $this->assertStatusCode(200, $client, 'An admin User should see the given user account information page');

        $this->assertHtmlContains($crawler, 'Profil Utilisateur');
        $this->assertHtmlContains($crawler, $user->getEmail());
        $this->assertHtmlContains($crawler, $user->getFirstName());
        $this->assertHtmlContains($crawler, $user->getLastName());
    }

    /**
     * Test that admin can delete given user
     */
    public function testSuccessDeleteUserAction()
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);
        $user = $this->getUserByEmail(self::USER_CLIENT);

        $em = $client->getContainer()->get('doctrine')->getManager();
        $em->beginTransaction();

        $url = $this->generateRoute('admin_delete_user', array('id' => $user->getId()));
        $client->request('DELETE', $url);

        $em->rollback();

        $this->assertRedirectTo($client, 'admin_show_all_user', array(), 'admin should be redirect successfully delete a user');
        $crawler = $client->followRedirect();

        $this->assertStatusCode(200, $client);

        $errorMessage = "Utilisateur " . $user->getFirstName() . " correctement supprimé";
        $this->assertHtmlContains($crawler, $errorMessage, 'Admin should see a confirmation flashMessage when he delete a given user');
    }

    /**
     * Test that admin cannot delete a not found user
     */
    public function testFailDeleteUser()
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);
        $url = $this->generateRoute('admin_delete_user', array('id' => 'gzej'));
        $client->request('DELETE', $url);

        $this->assertRedirectTo($client, 'admin_show_all_user', array(), 'admin should be redirect successfully delete a user');
        $crawler = $client->followRedirect();

        $this->assertStatusCode(200, $client);
        $this->assertFlashMessageContains($crawler, 'Utilisateur introuvable', 'Admin should see a error flashMessage when he delete a not found  user');
    }

    /**
     * Test that admin cannot delete an admin user
     */
    public function testFailDeleteAdminUser()
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);
        $user = $this->getUserByEmail(self::USER_ADMIN);

        $url = $this->generateRoute('admin_delete_user', array('id' => $user->getId()));
        $client->request('DELETE', $url);

        $this->assertRedirectTo($client, 'admin_show_all_user', array(), 'admin should be redirect successfully delete a user');
        $crawler = $client->followRedirect();

        $this->assertStatusCode(200, $client);
        $this->assertFlashMessageContains($crawler, 'Utilisateur '. $user->getFirstName() .' ne peut pas être supprimé', 'Admin should see a error flashMessage when he delete a not found  user');
    }

    /**
     * Test that admin can archive a user
     */
    public function testSuccessArchiveUserAction()
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);
        $user = $this->getUserByEmail(self::USER_CHEF_PROJET);

        $url = $this->generateRoute('admin_disable_user', array('id' => $user->getId()));
        $client->request('GET', $url);

        $this->assertRedirectTo($client, 'admin_show_all_user', array(), 'admin should be redirect successfully delete a user');
        $crawler = $client->followRedirect();

        $this->assertStatusCode(200, $client);
        $this->assertFlashMessageContains($crawler, 'Utilisateur ' . $user->getFirstName() . ' correctement désactivé', 'Admin should see a confirmation flashMessage when he archive a given user');

        // Check that user is correctly disabled
        $userStatus = $this->getUserByEmail(self::USER_CHEF_PROJET)->isEnabled();
        $this->assertEquals(0, $userStatus, 'Archived user should have isEnabled property set to 0');
    }

    /**
     * Test that admin cannot archive a not found user
     */
    public function testFailArchiveUser()
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);

        $url = $this->generateRoute('admin_disable_user', array('id' => 'ghfh'));
        $client->request('GET', $url);

        $this->assertRedirectTo($client, 'admin_show_all_user', array(), 'admin should be redirect successfully delete a user');
        $crawler = $client->followRedirect();

        $this->assertStatusCode(200, $client);
        $this->assertFlashMessageContains($crawler, 'Utilisateur introuvable', 'Admin should see a error flashMessage when he archive a NOT FOUND user');
    }

    /**
     * Test that admin cannot archive himself or another admin user
     */
    public function testFailArchiveAdmin()
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);
        $user = $this->getUserByEmail(self::USER_ADMIN);

        $url = $this->generateRoute('admin_disable_user', array('id' => $user->getId()));
        $client->request('GET', $url);

        $this->assertRedirectTo($client, 'admin_show_all_user', array(), 'admin should be redirect successfully delete a user');
        $crawler = $client->followRedirect();

        $this->assertStatusCode(200, $client);
        $this->assertFlashMessageContains($crawler, 'Utilisateur '. $user->getFirstName() .' ne peut pas être désactivé', 'Admin should see a error flashMessage when he archive a admin user');

        // Check that user is correctly disabled
        $userStatus = $this->getUserByEmail(self::USER_ADMIN)->isEnabled();
        $this->assertNotEquals(0, $userStatus, 'Admin user should NOT have isEnabled property set to 0 when admin try to archive it');
    }

    /**
     * Test that admin can activate a given user
     */
    public function testSuccessActivateUserAction()
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);
        $user = $this->getUserByEmail(self::USER_CHEF_PROJET);

        $url = $this->generateRoute('admin_activate_user', array('id' => $user->getId()));
        $client->request('GET', $url);

        $this->assertRedirectTo($client, 'admin_show_all_user', array(), 'admin should be redirect successfully delete a user');
        $crawler = $client->followRedirect();

        $this->assertStatusCode(200, $client);
        $this->assertFlashMessageContains($crawler, 'Utilisateur ' . $user->getFirstName() . ' correctement activé', 'Admin should see a confirmation flashMessage when he archive a given user');

        // Check that user is correctly disabled
        $userStatus = $this->getUserByEmail(self::USER_CHEF_PROJET)->isEnabled();
        $this->assertEquals(1, $userStatus, 'User activated should have isEnabled property set to 1');
    }

    /**
     * Test that admin cannot activate a not found user
     */
    public function testFailActivateUser()
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);

        $url = $this->generateRoute('admin_activate_user', array('id' => 'ghfh'));
        $client->request('GET', $url);

        $this->assertRedirectTo($client, 'admin_show_all_user', array(), 'admin should be redirect successfully delete a user');
        $crawler = $client->followRedirect();

        $this->assertStatusCode(200, $client);
        $this->assertFlashMessageContains($crawler, 'Utilisateur introuvable', 'Admin should see a error flashMessage when he try to activate a NOT FOUND user');
    }
}
