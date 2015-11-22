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