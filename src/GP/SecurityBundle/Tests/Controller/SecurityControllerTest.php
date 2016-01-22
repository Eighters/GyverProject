<?php

namespace GP\SecurityBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Unit testing for the Security controller
 *
 * @package GP\SecurityBundle\Tests\Controller
 */
class SecurityControllerTest extends WebTestCase
{

    /**
     * Unit testing the indexAction function
     */
    public function testIndexAction()
    {
        $client = static::createClient();

        $client->request("GET", "/");

        // Assert that the response status code is 3xx
        $this->assertTrue($client->getResponse()->isRedirection());

        // Follow the redirection to the login action
        $client->followRedirect();

        // Assert that the response status code is 2xx
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * Unit testing the loginAction function
     */
    public function testLoginAction()
    {
        $client = static::createClient();

        $client->request('GET', '/login');

        // Assert that the response status code is 2xx
        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}