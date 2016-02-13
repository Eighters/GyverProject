<?php

namespace GP\UserBundle\Tests\Controller;

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
        $client = $this->LoginUsingFormUser($userName, $password);
        $url = $this->generateRoute($client, 'admin_dashboard');
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
                'message' => 'An admin User should see the manage company page',
            ),
            array(
                'userName' => 'thibaut',
                'password' => self::USER_PASSWORD,
                'expectedStatusCode' => '403',
                'message' => 'An NON admin User should NOT see the manage company page',
            ),
        );
    }

}
