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
        $client = $this->loginUsingFormUser($userName, $password);
        $url = $this->generateRoute($client, 'admin_dashboard');
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
                'message' => 'An admin User should see the admin dashboard page',
            ),
            array(
                'userName' => self::USER_CHEF_PROJET,
                'password' => self::USER_PASSWORD,
                'expectedStatusCode' => '403',
                'message' => 'An NON admin User should NOT see the admin dashboard page',
            ),
        );
    }

    /**
     * Test that only admin can access Manage user page
     */
    public function testShowUsersAction()
    {
        $client = $this->loginUsingFormUser(self::USER_ADMIN, self::USER_PASSWORD);
        $url = $this->generateRoute($client, 'admin_show_all_user');
        $this->crawler =  $client->request('GET', $url);

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'An admin User should see the admin manage user page');

        $this->assertHtmlContains($this->crawler, 'Gestion des utilisateurs', 'Admin should see the manage user page right title');

        $totalUser = $this->getTotalUser($client);
        $this->assertHtmlContains($this->crawler, 'Vous avez ' . $totalUser . ' utilisateurs', 'Admin should see ' . $totalUser . ' users listed in the manage user page');
    }

    /**
     * Test that only admin can access to a given user account summary page
     */
    public function testShowUserAction()
    {
        $client = $this->loginUsingFormUser(self::USER_ADMIN, self::USER_PASSWORD);
        $user = $this->getUserByEmail(self::USER_CHEF_PROJET, $client);
        $url = $this->generateRoute($client, 'admin_show_user', array('id' => $user->getId()));
        $this->crawler =  $client->request('GET', $url);

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'An admin User should see the given user account information page');

        $this->assertHtmlContains($this->crawler, 'Profil utilisateur');
        $this->assertHtmlContains($this->crawler, $user->getEmail());
        $this->assertHtmlContains($this->crawler, $user->getFirstName());
        $this->assertHtmlContains($this->crawler, $user->getLastName());
    }

    /**
     * Test that admin can delete given user
     */
    public function testSuccessDeleteUserAction()
    {
        $client = $this->loginUsingFormUser(self::USER_ADMIN, self::USER_PASSWORD);
        $user = $this->getUserByEmail('gyver.project+deleted@gmail.com', $client);

        $url = $this->generateRoute($client, 'admin_delete_user', array('id' => $user->getId()));
        $this->crawler =  $client->request('DELETE', $url);

        // Assert flash message is present and status code is 200
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertFlashMessageContains($this->crawler, 'Utilisateur ' . $user->getFirstName() . ' correctement supprimé', 'Admin should see a confirmation flashMessage when he delete a given user');
    }

    /**
     * Test that admin cannot delete a not found user
     */
    public function testFailDeleteUser()
    {
        $client = $this->loginUsingFormUser(self::USER_ADMIN, self::USER_PASSWORD);
        $url = $this->generateRoute($client, 'admin_delete_user', array('id' => 'gzej'));
        $this->crawler =  $client->request('DELETE', $url);

        // Assert flash message is present and status code is 200
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertFlashMessageContains($this->crawler, 'Utilisateur introuvable', 'Admin should see a error flashMessage when he delete a not found  user');
    }

    /**
     * Test that admin cannot delete an admin user
     */
    public function testFailDeleteAdminUser()
    {
        $client = $this->loginUsingFormUser(self::USER_ADMIN, self::USER_PASSWORD);
        $user = $this->getUserByEmail(self::USER_ADMIN, $client);

        $url = $this->generateRoute($client, 'admin_delete_user', array('id' => $user->getId()));
        $this->crawler =  $client->request('DELETE', $url);

        // Assert flash message is present and status code is 200
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertFlashMessageContains($this->crawler, 'Utilisateur '. $user->getFirstName() .' ne peut pas être supprimé', 'Admin should see a error flashMessage when he delete a not found  user');
    }

    /**
     * Test that admin can archive a user
     */
    public function testSuccessArchiveUserAction()
    {
        $client = $this->loginUsingFormUser(self::USER_ADMIN, self::USER_PASSWORD);
        $user = $this->getUserByEmail(self::USER_CHEF_PROJET, $client);

        $url = $this->generateRoute($client, 'admin_disable_user', array('id' => $user->getId()));
        $this->crawler =  $client->request('GET', $url);

        // Assert flash message is present and status code is 200
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertFlashMessageContains($this->crawler, 'Utilisateur ' . $user->getFirstName() . ' correctement désactivé', 'Admin should see a confirmation flashMessage when he archive a given user');

        // Check that user is correctly disabled
        $userStatus = $this->getUserByEmail(self::USER_CHEF_PROJET, $client)->isEnabled();
        $this->assertEquals(0, $userStatus, 'Archived user should have isEnabled property set to 0');
    }

    /**
     * Test that admin cannot archive a not found user
     */
    public function testFailArchiveUser()
    {
        $client = $this->loginUsingFormUser(self::USER_ADMIN, self::USER_PASSWORD);

        $url = $this->generateRoute($client, 'admin_disable_user', array('id' => 'ghfh'));
        $this->crawler =  $client->request('GET', $url);

        // Assert flash message is present and status code is 200
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertFlashMessageContains($this->crawler, 'Utilisateur introuvable', 'Admin should see a error flashMessage when he archive a NOT FOUND user');
    }

    /**
     * Test that admin cannot archive himself or another admin user
     */
    public function testFailArchiveAdmin()
    {
        $client = $this->loginUsingFormUser(self::USER_ADMIN, self::USER_PASSWORD);
        $user = $this->getUserByEmail(self::USER_ADMIN, $client);

        $url = $this->generateRoute($client, 'admin_disable_user', array('id' => $user->getId()));
        $this->crawler =  $client->request('GET', $url);

        // Assert flash message is present and status code is 200
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertFlashMessageContains($this->crawler, 'Utilisateur '. $user->getFirstName() .' ne peut pas être désactivé', 'Admin should see a error flashMessage when he archive a admin user');

        // Check that user is correctly disabled
        $userStatus = $this->getUserByEmail(self::USER_ADMIN, $client)->isEnabled();
        $this->assertNotEquals(0, $userStatus, 'Admin user should NOT have isEnabled property set to 0 when admin try to archive it');
    }

    /**
     * Test that admin can activate a given user
     */
    public function testSuccessActivateUserAction()
    {
        $client = $this->loginUsingFormUser(self::USER_ADMIN, self::USER_PASSWORD);
        $user = $this->getUserByEmail(self::USER_CHEF_PROJET, $client);

        $url = $this->generateRoute($client, 'admin_activate_user', array('id' => $user->getId()));
        $this->crawler =  $client->request('GET', $url);

        // Assert flash message is present and status code is 200
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertFlashMessageContains($this->crawler, 'Utilisateur ' . $user->getFirstName() . ' correctement activé', 'Admin should see a confirmation flashMessage when he archive a given user');

        // Check that user is correctly disabled
        $userStatus = $this->getUserByEmail(self::USER_CHEF_PROJET, $client)->isEnabled();
        $this->assertEquals(1, $userStatus, 'User activated should have isEnabled property set to 1');
    }

    /**
     * Test that admin cannot activate a not found user
     */
    public function testFailActivateUser()
    {
        $client = $this->loginUsingFormUser(self::USER_ADMIN, self::USER_PASSWORD);

        $url = $this->generateRoute($client, 'admin_activate_user', array('id' => 'ghfh'));
        $this->crawler =  $client->request('GET', $url);

        // Assert flash message is present and status code is 200
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertFlashMessageContains($this->crawler, 'Utilisateur introuvable', 'Admin should see a error flashMessage when he try to activate a NOT FOUND user');
    }

}
