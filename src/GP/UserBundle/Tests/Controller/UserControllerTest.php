<?php

namespace GP\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Unit testing for the User controller
 *
 * @package GP\UserBundle\Tests\Controller
 */
class UserControllerTest extends WebTestCase
{

    /**
     * Unit testing the showUsersAction function
     */
    public function testShowUsersAction()
    {
        $client = static::createClient();

        $client->request('GET', '/secure/admin/user');

        // Assert that the response status code is 3xx
        $this->assertTrue($client->getResponse()->isRedirection());
    }

    /**
     * Unit testing the showUserAction function
     */
    public function testShowUserAction()
    {
        $client = static::createClient();

        $client->request('GET', '/secure/admin/user/1');

        // Assert that the response status code is 3xx
        $this->assertTrue($client->getResponse()->isRedirection());
    }
}
