<?php

namespace GP\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Unit testing for the Dashboard controller
 *
 * @package GP\UserBundle\Tests\Controller
 */
class DashboardControllerTest extends WebTestCase
{

    /**
     * Unit testing the indexAction function
     */
    public function testIndexAction()
    {
        $client = static::createClient();

        $client->request('GET', '/secure');

        // Assert that the response status code is 3xx
        $this->assertTrue($client->getResponse()->isRedirection());
    }
}