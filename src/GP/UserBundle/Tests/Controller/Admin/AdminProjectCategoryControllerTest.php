<?php

namespace GP\UserBundle\Tests\Controller;

use GP\CoreBundle\Entity\ProjectCategory;
use GP\CoreBundle\Tests\BaseTestCase;

/**
 * Unit testing for the Admin ProjectCategory Controller
 *
 * @package GP\UserBundle\Tests\Controller\Admin
 */
class AdminProjectCategoryControllerTest extends BaseTestCase
{
    CONST GLOBAL_CATEGORY_NAME = "test create global project category";
    CONST COMPANY_CATEGORY_NAME = "test create SFR project category";

    /**
     * Test only admin can access to project category list page
     *
     * @dataProvider userProvider
     *
     * @param $userName
     * @param $password
     * @param $expectedStatusCode
     * @param $message
     */
    public function testAccessShowAllProjectCategoriesAction($userName, $password, $expectedStatusCode, $message)
    {
        $client = $this->connectUser($userName, $password);
        $url = $this->generateRoute('admin_show_all_project_categories');
        $client->request('GET', $url);

        $this->assertStatusCode($expectedStatusCode, $client, $message);
    }

    /**
     * Test only admin can create a new project category
     *
     * @dataProvider userProvider
     *
     * @param $userName
     * @param $password
     * @param $expectedStatusCode
     * @param $message
     */
    public function testAccessCreateProjectCategoryAction($userName, $password, $expectedStatusCode, $message)
    {
        $client = $this->connectUser($userName, $password);
        $url = $this->generateRoute('admin_create_project_category');
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
                'message' => 'An admin User should see the project category page',
            ),
            array(
                'userName' => self::USER_DEVELOPPEUR,
                'password' => self::USER_PASSWORD,
                'expectedStatusCode' => '403',
                'message' => 'An NON admin User should NOT see the project category page',
            ),
        );
    }

    /**
     * Test admin can create new global project category
     */
    public function testSuccessCreateGlobalProjectCategoryAction()
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);

        $url = $this->generateRoute('admin_create_project_category');
        $crawler = $client->request('GET', $url);
        $this->assertStatusCode(200, $client);

        $form = $crawler->selectButton('_submit')->form();

        $form["new_project_category[global]"]->select('1');

        $client->submit($form, array(
            "new_project_category[name]" => self::GLOBAL_CATEGORY_NAME,
        ));

        $this->assertRedirectTo($client, 'admin_show_all_project_categories');
        $crawler = $client->followRedirect();

        $this->assertStatusCode(200, $client);

        $this->assertFlashMessageContains(
            $crawler,
            "La catégorie ". self::GLOBAL_CATEGORY_NAME ." a été correctement crée",
            'Admin should see confirmation flashMessage when he successfully create new global project category'
        );
    }

    /**
     * Test admin can create new project category for a given Company
     */
    public function testSuccessCreateCompanyProjectCategoryAction()
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);
        $company = $this->getCompanyByName(self::COMPANY_NAME);

        $url = $this->generateRoute('admin_create_project_category');
        $crawler = $client->request('GET', $url);

        $this->assertStatusCode(200, $client);

        $form = $crawler->selectButton('_submit')->form();

        $form["new_project_category[global]"]->select('0');
        $form["new_project_category[company]"]->select($company->getId());

        $client->submit($form, array(
            "new_project_category[name]" => self::COMPANY_CATEGORY_NAME,
        ));

        $this->assertRedirectTo($client, 'admin_show_all_project_categories');
        $crawler = $client->followRedirect();

        $this->assertStatusCode(200, $client);

        $this->assertFlashMessageContains(
            $crawler,
            "La catégorie ". self::COMPANY_CATEGORY_NAME ." a été correctement crée",
            'Admin should see confirmation flashMessage when he successfully create new global project category'
        );
    }

    /**
     * Test admin can delete Project Category successfully
     *
     * @depends testSuccessCreateGlobalProjectCategoryAction
     * @depends testSuccessCreateCompanyProjectCategoryAction
     *
     * @dataProvider projectCategoryProvider
     *
     * @param $projectCategoryName
     * @param $successMessage
     */
    public function testDeleteProjectCategory($projectCategoryName, $successMessage)
    {
        $client = $this->connectUser(self::USER_ADMIN, self::USER_PASSWORD);

        $em = $client->getContainer()->get('doctrine')->getManager();
        /** @var ProjectCategory $projectCategory */
        $projectCategory = $em->getRepository('GPCoreBundle:ProjectCategory')->findOneByName($projectCategoryName);

        $url = $this->generateRoute('admin_delete_project_category', array('id' => $projectCategory->getId()));
        $client->request('GET', $url);

        $this->assertRedirectTo($client, 'admin_show_all_project_categories');
        $crawler = $client->followRedirect();

        $this->assertFlashMessageContains(
            $crawler,
            $successMessage,
            'Admin should see confirmation flashMessage when he successfully delete a project category'
        );
    }

    public function projectCategoryProvider()
    {
        return array (
            array(
                'projectCategoryName' => self::COMPANY_CATEGORY_NAME,
                'successMessage' => 'La catégorie de projet '. self::COMPANY_CATEGORY_NAME .' a été correctement supprimé',
            ),
            array(
                'projectCategoryName' => self::GLOBAL_CATEGORY_NAME,
                'successMessage' => 'La catégorie de projet '. self::GLOBAL_CATEGORY_NAME .' a été correctement supprimé',
            ),
        );
    }
}
