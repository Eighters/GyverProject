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
     * Test only admin can access to manage project page
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
        $client = $this->loginUsingFormUser($userName, $password);
        $url = $this->generateRoute($client, 'admin_show_all_project');
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
