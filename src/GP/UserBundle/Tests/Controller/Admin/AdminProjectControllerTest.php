<?php

namespace GP\UserBundle\Tests\Controller;

use GP\CoreBundle\Entity\Company;
use GP\CoreBundle\Entity\ProjectCategory;
use GP\CoreBundle\Tests\BaseTestCase;

/**
 * Unit testing for the admin project controller
 *
 * @package GP\UserBundle\Tests\Controller\Admin
 */
class AdminProjectControllerTest extends BaseTestCase
{
    /**
     * Test only admin can access to project dashboard
     *
     * @dataProvider userProvider
     *
     * @param $userName
     * @param $password
     * @param $expectedStatusCode
     * @param $message
     */
    public function testAccessShowProjectsAction($userName, $password, $expectedStatusCode, $message)
    {
        $client = $this->connectUser($userName, $password);
        $url = $this->generateRoute('admin_show_all_project');
        $client->request('GET', $url);

        $this->assertStatusCode($expectedStatusCode, $client, $message);
    }

    /**
     * Test only admin can access to project details page
     *
     * @dataProvider userProvider
     *
     * @param $userName
     * @param $password
     * @param $expectedStatusCode
     * @param $message
     */
    public function testAccessShowProjectAction($userName, $password, $expectedStatusCode, $message)
    {
        $client = $this->connectUser($userName, $password);
        $project = $this->getProjectByName(BaseTestCase::PROJECT_NAME);

        $url = $this->generateRoute('admin_show_project', array('id' => $project->getId()));
        $client->request('GET', $url);

        $this->assertStatusCode($expectedStatusCode, $client, $message);
    }

    public function userProvider()
    {
        return array (
            array(
                'userName' => 'admin',
                'password' => self::USER_PASSWORD,
                'expectedStatusCode' => 200,
                'message' => 'An admin User should see the manage project page',
            ),
            array(
                'userName' => 'thibaut',
                'password' => self::USER_PASSWORD,
                'expectedStatusCode' => 403,
                'message' => 'An NON admin User should NOT see the manage project page',
            ),
        );
    }

    /**
     * Test that only admin can access to the project creation page
     *
     * @dataProvider userAccessProvider
     *
     * @param $userName
     * @param $password
     * @param $expectedStatusCode
     * @param $message
     */
    public function testCreateProjectActionIsSecure($userName, $password, $expectedStatusCode, $message)
    {
        $client = $this->connectUser($userName, $password);

        $url = $this->generateRoute('admin_create_project');
        $client->request('GET', $url);
        $this->assertStatusCode($expectedStatusCode, $client, $message);
    }

    public function userAccessProvider()
    {
        return array (
            array(
                'userName' => self::USER_ADMIN,
                'password' => self::USER_PASSWORD,
                'expectedStatusCode' => 200,
                'message' => 'Admin user should have access to the project creation page'
            ),
//            array(
//                'userName' => self::USER_CHEF_PROJET,
//                'password' => self::USER_PASSWORD,
//                'expectedStatusCode' => 302,
//                'message' => 'Regular user should not have access to the project creation page'
//            ),
        );
    }

    /**
     * Test that admin can successfully create new project
     */
    public function testCreateProjectAction()
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);
        $em = $client->getContainer()->get('doctrine')->getManager();

        $url = $this->generateRoute('admin_create_project');
        $crawler = $client->request('GET', $url);
        $this->assertStatusCode(200, $client);

        $company = $this->getCompanyByName(self::COMPANY_NAME);
        $projectCategory = $this->getProjectCategoryByName(self::PROJECT_CATEGORY_NAME);

        $form = $crawler->selectButton('_submit')->form();

        $form["create_project[companies]"]->select($company->getId());
        $form["create_project[projectCategory]"]->select($projectCategory->getId());

        $baseDate = new \DateTime('now');
        $client->submit($form, array(
            "create_project[name]" => self::PROJECT_TEST_NAME,
            "create_project[description]" => self::PROJECT_TEST_NAME . " description",
            "create_project[beginDate]" => $baseDate->modify('+1 months')->format('Y-m-d'),
            "create_project[plannedEndDate]" => $baseDate->modify('+2 months')->format('Y-m-d'),
        ));

        $newProject = $em->getRepository('GPCoreBundle:Project')->findOneByName(self::PROJECT_TEST_NAME);
        $this->assertRedirectTo($client, 'admin_show_project', array('id' => $newProject->getId()));
        $crawler = $client->followRedirect();

        $this->assertStatusCode(200, $client);
        $this->assertFlashMessageContains(
            $crawler,
            "Le projet " . $newProject->getName() . " a été correctement crée",
            'Admin should see confirmation flashMessage when he successfully create new access role'
        );
    }

    /**
     * Test errors on create new project form
     *
     * @depends testCreateProjectAction
     * @dataProvider createProjectProvider
     *
     * @param $formSelect
     * @param $formInputData
     * @param $errors
     */
    public function testFailCreateProjectAction($formSelect, $formInputData, $errors)
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);

        $url = $this->generateRoute('admin_create_project');
        $crawler = $client->request('GET', $url);
        $this->assertStatusCode(200, $client);

        $company = $this->getCompanyByName($formSelect['companyName']);
        $projectCategory = $this->getProjectCategoryByName($formSelect['projectCategoryName']);

        if (!$company) {
            $company = new Company();
        }

        if (!$projectCategory) {
            $projectCategory = new ProjectCategory();
        }

        $form = $crawler->selectButton('_submit')->form();
        $form["create_project[companies]"]->select($company->getId());
        $form["create_project[projectCategory]"]->select($projectCategory->getId());

        $crawler = $client->submit($form, $formInputData);

        $this->assertStatusCode(200, $client);

        foreach($errors as $error) {
            $this->assertHtmlContains($crawler, $error);
        }
    }

    public function createProjectProvider()
    {
        $beginDate = new \DateTime('now');
        $endingDate = new \DateTime('now');

        return array (
            array(
                'formSelect' => array(
                    'companyName'           => ' ',
                    'projectCategoryName'   => ' '
                ),
                'formInputData' => array(
                    'create_project[name]'             => ' ',
                    'create_project[description]'      => ' ',
                    'create_project[beginDate]'        => ' ',
                    'create_project[plannedEndDate]'   => ' '

                ),
                'errors' => array(
                    'name'              => "Vous devez spécifiez un nom de projet",
                    'description'       => "Vous devez spécifiez une description",
                    'company'           => "Veuillez selectionner une entreprise participante pour le projet",
                    'projectCategory'   => "Veuillez selectionner une catégorie pour le projet"
                )
            ),
            array(
                'formSelect' => array(
                    'companyName'           => self::COMPANY_NAME,
                    'projectCategoryName'   => self::PROJECT_CATEGORY_NAME
                ),
                'formInputData' => array(
                    'create_project[name]'             => 'k',
                    'create_project[description]'      => 'k',
                    'create_project[beginDate]'        => $beginDate->modify('+1 months')->format('Y-m-d'),
                    'create_project[plannedEndDate]'   => $endingDate->modify('+1 months')->format('Y-m-d')

                ),
                'errors' => array(
                    'name'              => "Le nom du projet doit faire un minimum de 3 caractères",
                    'description'       => "La description du projet doit faire un minimum de 3 caractères",
                    'plannedEndDate'    => "La date de début et la date de fin du projet ne peuvent être semblables",
                )
            ),
            array(
                'formSelect' => array(
                    'companyName'           => self::COMPANY_NAME,
                    'projectCategoryName'   => self::PROJECT_CATEGORY_NAME
                ),
                'formInputData' => array(
                    'create_project[name]'             => self::PROJECT_TEST_NAME,
                    'create_project[description]'      => 'kkkkkkk',
                    'create_project[beginDate]'        => $beginDate->modify('+2 months')->format('Y-m-d'),
                    'create_project[plannedEndDate]'   => $endingDate->modify('+1 months')->format('Y-m-d')

                ),
                'errors' => array(
                    'name'              => "Le nom de projet est déja pris",
                    'plannedEndDate'    => "La date de fin du projet doit être antérieure à celle du début",
                )
            )
        );
    }

    /**
     * Test that admin can delete given project
     *
     * @depends testCreateProjectAction
     */
    public function testDeleteProjectAction()
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);
        $project = $this->getProjectByName(self::PROJECT_TEST_NAME);

        $url = $this->generateRoute('admin_delete_project', array('id' => $project->getId()));
        $client->request('DELETE', $url);

        $this->assertRedirectTo($client, 'admin_show_all_project');
        $crawler = $client->followRedirect();

        $this->assertStatusCode(200, $client);
        $this->assertFlashMessageContains(
            $crawler,
            "Le projet a été supprimé avec succès",
            'Admin should see confirmation flashMessage when he successfully delete project'
        );
    }

    /**
     * Test Errors on delete project action
     *
     * @depends testDeleteProjectAction
     */
    public function testFailDeleteProjectAction()
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);

        $url = $this->generateRoute('admin_delete_project', array('id' => 'kkk'));
        $client->request('DELETE', $url);

        $this->assertRedirectTo($client, 'admin_show_all_project');
        $crawler = $client->followRedirect();

        $this->assertStatusCode(200, $client);
        $this->assertFlashMessageContains(
            $crawler,
            "Projet introuvable",
            'Admin should see error flashMessage when he delete a not found project'
        );
    }
}
