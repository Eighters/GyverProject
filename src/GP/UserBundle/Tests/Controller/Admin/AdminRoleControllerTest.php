<?php

namespace GP\UserBundle\Tests\Controller;

use GP\CoreBundle\Entity\AccessRole;
use GP\CoreBundle\Tests\BaseTestCase;

/**
 * Unit testing for the Admin Role Controller
 *
 * @package GP\UserBundle\Tests\Controller\Admin
 */
class AdminRoleControllerTest extends BaseTestCase
{
    /**
     * Test only admin can access to access roles list page
     *
     * @dataProvider userProvider
     *
     * @param $userName
     * @param $password
     * @param $expectedStatusCode
     * @param $message
     */
    public function testAccessShowAccessRolesAction($userName, $password, $expectedStatusCode, $message)
    {
        $client = $this->connectUser($userName, $password);
        $url = $this->generateRoute('admin_show_all_access_roles');
        $client->request('GET', $url);

        $this->assertStatusCode($expectedStatusCode, $client, $message);
    }

    /**
     * Test only admin can show given access role
     *
     * @dataProvider userProvider
     *
     * @param $userName
     * @param $password
     * @param $expectedStatusCode
     * @param $message
     */
    public function testAccessShowAccessRoleAction($userName, $password, $expectedStatusCode, $message)
    {
        $client = $this->connectUser($userName, $password);

        $role = $this->getRoleByName(self::ROLE_COMPANY_NAME);
        $url = $this->generateRoute('admin_show_access_role', array('id' => $role->getId()));
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
                'message' => 'An admin User should see the user access role list',
            ),
            array(
                'userName' => self::USER_DEVELOPPEUR,
                'password' => self::USER_PASSWORD,
                'expectedStatusCode' => '403',
                'message' => 'An NON admin User should NOT see the user access role list',
            ),
        );
    }

    /**
     * Test error on show access role action
     */
    public function testErrorShowAccessRoleAction()
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);

        $url = $this->generateRoute('admin_show_access_role', array('id' => 'kkk'));
        $client->request('GET', $url);

        $this->assertRedirectTo($client, 'admin_show_all_access_roles');
        $crawler = $client->followRedirect();

        $this->assertFlashMessageContains(
            $crawler,
            "Le rôle est introuvable",
            "Admin should see error flashMessage when want to see a nout found access role"
        );
    }

    /**
     * Test that admin can create new access role for company
     */
    public function testCreateCompanyRoleAction()
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);

        $company = $this->getCompanyByName(self::COMPANY_NAME);
        $url = $this->generateRoute('admin_create_company_access_role', array('id' => $company->getId()));
        $crawler = $client->request('GET', $url);

        $this->assertStatusCode(200, $client);

        $form = $crawler->selectButton('_submit')->form();

        $client->submit($form, array(
            "add_access_role[name]" => self::ROLE_TEST_NAME,
            "add_access_role[description]" => self::ROLE_TEST_NAME . " description",
        ));

        $this->assertRedirectTo($client, 'admin_show_company', array('id' => $company->getId()));
        $crawler = $client->followRedirect();

        $this->assertStatusCode(200, $client);

        $this->assertFlashMessageContains(
            $crawler,
            "Le rôle: " . self::ROLE_TEST_NAME . " a été ajouté avec succès à l'entreprise " . $company->getName(),
            'Admin should see confirmation flashMessage when he successfully create new company access role'
        );
    }

    /**
     * Test that admin can create new access role for project
     */
    public function testCreateProjectRoleAction()
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);

        $project = $this->getProjectByName(self::PROJECT_NAME);
        $url = $this->generateRoute('admin_create_project_access_role', array('id' => $project->getId()));
        $crawler = $client->request('GET', $url);

        $this->assertStatusCode(200, $client);

        $form = $crawler->selectButton('_submit')->form();

        $client->submit($form, array(
            "add_access_role[name]" => self::ROLE_TEST_NAME,
            "add_access_role[description]" => self::ROLE_TEST_NAME . " description",
        ));

        $this->assertRedirectTo($client, 'admin_show_project', array('id' => $project->getId()));
        $crawler = $client->followRedirect();

        $this->assertStatusCode(200, $client);

        $this->assertFlashMessageContains(
            $crawler,
            "Le rôle: " . self::ROLE_TEST_NAME . " a été ajouté avec succès au projet " . $project->getName(),
            'Admin should see confirmation flashMessage when he successfully create new project access role'
        );
    }

    /**
     * Test that admin can delete given access role
     *
     * @depends testCreateCompanyRoleAction
     * @depends testCreateProjectRoleAction
     *
     * @dataProvider accessRoleProvider
     *
     * @param $accessRoleName
     * @param $successMessage
     */
    public function testDeleteAccessRoleAction($accessRoleName, $successMessage)
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);

        $em = $client->getContainer()->get('doctrine')->getManager();
        /** @var AccessRole $accessRole */
        $accessRole = $em->getRepository('GPCoreBundle:AccessRole')->findOneByName($accessRoleName);

        $url = $this->generateRoute('admin_delete_access_role', array('id' => $accessRole->getId()));
        $client->request('DELETE', $url);

        $this->assertRedirectTo($client, 'admin_show_all_access_roles');
        $crawler = $client->followRedirect();

        $this->assertFlashMessageContains(
            $crawler,
            $successMessage,
            'Admin should see confirmation flashMessage when he successfully delete a given access role'
        );
    }

    public function accessRoleProvider()
    {
        return array (
            array(
                'accessRoleName' => self::ROLE_TEST_NAME,
                'successMessage' => "Le rôle " . self::ROLE_TEST_NAME . " a été supprimé avec succès",
            ),
            array(
                'accessRoleName' => self::ROLE_TEST_NAME,
                'successMessage' => "Le rôle " . self::ROLE_TEST_NAME . " a été supprimé avec succès",
            ),
        );
    }

    /**
     * Test that admin can add new user to a given access role
     */
    public function testAddUserToAccessRoleAction()
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);
        $em = $client->getContainer()->get('doctrine')->getManager();
        /** @var AccessRole $accessRole */
        $accessRole = $em->getRepository('GPCoreBundle:AccessRole')->findOneByName(self::ROLE_COMPANY_NAME);

        $url = $this->generateRoute('admin_add_user_access_role', array('id' => $accessRole->getId()));
        $crawler = $client->request('GET', $url);

        $this->assertStatusCode(200, $client);

        $user = $this->getUserByEmail(self::USER_COLLABORATEUR);

        $form = $crawler->selectButton('_submit')->form();

        $form["add_user_to_access_role[users]"]->select($user->getId());

        $client->submit($form);

        $this->assertRedirectTo($client, 'admin_show_access_role', array('id' => $accessRole->getId()));
        $crawler = $client->followRedirect();

        $username = $user->getFirstName() . " " . $user->getLastName();
        $this->assertFlashMessageContains(
            $crawler,
            "Le rôle ". $accessRole->getName(). " a bien été affecté à l'utilisateur " . $username,
            'Admin should see confirmation flashMessage when he successfully add new user to an access role'
        );
    }

    /**
     * Test that admin can remove user from access role
     *
     * @depends testAddUserToAccessRoleAction
     */
    public function testRemoveAccessRoleForUserAction()
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);
        $em = $client->getContainer()->get('doctrine')->getManager();
        /** @var AccessRole $accessRole */
        $accessRole = $em->getRepository('GPCoreBundle:AccessRole')->findOneByName(self::ROLE_COMPANY_NAME);
        $user = $this->getUserByEmail(self::USER_COLLABORATEUR);

        $url = $this->generateRoute('admin_remove_user_access_role', array('id' => $accessRole->getId(), 'user_id' => $user->getId()));
        $client->request('DELETE', $url);

        $this->assertRedirectTo($client, 'admin_show_access_role', array('id' => $accessRole->getId()));
        $crawler = $client->followRedirect();

        $username = $user->getFirstName() . " " . $user->getLastName();
        $this->assertFlashMessageContains(
            $crawler,
            "Le rôle ". $accessRole->getName(). " a été retiré à l'utilisateur "  . $username,
            'Admin should see confirmation flashMessage when he successfully add new user to an access role'
        );
    }
}
