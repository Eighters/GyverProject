<?php

namespace GyverBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class HomeControllerTest
 *
 * Unit testing for the HomeController
 *
 * @package GyverBundle\Tests\Controller
 */
class HomeControllerTest extends WebTestCase
{
    /**
     * IndexAction method test
     *
     * Expected redirection to user login form view
     *
     * - Assert if the returned status code equals 301.
     */
    public function testIndexAction()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertEquals(301, $client->getResponse()->getStatusCode());
    }
}