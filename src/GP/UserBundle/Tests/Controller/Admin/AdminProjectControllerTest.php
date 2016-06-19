<?php

namespace GP\UserBundle\Tests\Controller;

use GP\CoreBundle\Tests\BaseTestCase;

/**
 * Unit testing for the Dashboard controller
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

        $this->assertEquals($expectedStatusCode, $client->getResponse()->getStatusCode(), $message);
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

        $this->assertEquals($expectedStatusCode, $client->getResponse()->getStatusCode(), $message);
    }

    public function userProvider()
    {
        return array (
            array(
                'userName' => 'admin',
                'password' => self::USER_PASSWORD,
                'expectedStatusCode' => '200',
                'message' => 'An admin User should see the manage project page',
            ),
            array(
                'userName' => 'thibaut',
                'password' => self::USER_PASSWORD,
                'expectedStatusCode' => '403',
                'message' => 'An NON admin User should NOT see the manage project page',
            ),
        );
    }

}
