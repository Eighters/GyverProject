<?php

namespace GP\ProjectBundle\Tests\Controller;

use GP\CoreBundle\Tests\BaseTestCase;

/**
 * Unit testing for the Project Controller
 *
 * @package GP\UserBundle\Tests\Controller\Admin
 */
class ProjectControllerTest extends BaseTestCase
{
    /**
     * Test access to project list dashboard
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
        $url = $this->generateRoute('show_all_projects');
        $client->request('GET', $url);

        $this->assertStatusCode($expectedStatusCode, $client, $message);
    }

    /**
     * Test access to project details page
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
        $project = $this->getProjectByName(self::PROJECT_NAME);

        $url = $this->generateRoute('show_project', array('id' => $project->getId()));
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
                'message' => 'An admin User should see every project pages',
            ),
            array(
                'userName' => self::USER_DEVELOPPEUR,
                'password' => self::USER_PASSWORD,
                'expectedStatusCode' => '200',
                'message' => 'A regular user should see project pages only if he have granted access to',
            ),
        );
    }

    /**
     * Test access to non authorized project details page
     */
    public function testAccessForbiddenShowProjectAction()
    {
        $client = $this->connectUser(self::USER_CLIENT, self::USER_PASSWORD);
        $project = $this->getProjectByName(self::PROJECT_NAME);

        $url = $this->generateRoute('show_project', array('id' => $project->getId()));
        $client->request('GET', $url);

        $this->assertStatusCode(403, $client, 'A regular user should NOT have access to project pages when is not a member of him');
    }

    /**
     * Test access to not found project
     */
    public function testAccessNotFoundProjectAction()
    {
        $client = $this->connectUser(self::USER_DEVELOPPEUR, self::USER_PASSWORD);
        $url = $this->generateRoute('show_project', array('id' => 'kkk'));
        $client->request('GET', $url);

        $this->assertRedirectTo($client, 'show_all_projects', array(), 'A regular user should be redirect to projects list view when request a not found company');
        $crawler = $client->followRedirect();

        $this->assertStatusCode(200, $client);

        $this->assertFlashMessageContains(
            $crawler,
            "Projet introuvable",
            'A regular user should should see an error flashMessage when request a not found project'
        );
    }
}
