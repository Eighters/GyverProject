<?php

namespace GP\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Unit testing for the Dashboard controller
 *
 * @package GP\UserBundle\Tests\Controller
 */
class AccountControllerTest extends WebTestCase
{

    /**
     * Unit testing the showAccountAction function
     */
    public function testShowAccountAction()
    {
        $client = static::createClient();

        $client->request('GET', '/secure/account');

        // Assert that the response status code is 3xx
        $this->assertTrue($client->getResponse()->isRedirection());
    }

    /**
     * Unit testing the editAccountAction function
     */
    public function testEditAccountAction()
    {
        $client = static::createClient();

        $client->request('GET', '/secure/account/edit');

        // Assert that the response status code is 3xx
        $this->assertTrue($client->getResponse()->isRedirection());
    }
}