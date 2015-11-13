<?php

namespace GyverBundle\Tests\Controller\User;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class SecurityControllerTest
 *
 * Unit testing for the SecurityController
 *
 * @package GyverBundle\Tests\Controller\User
 */
class SecurityControllerTest extends WebTestCase
{
    /**
     * loginAction method test
     * - Assert if the returned status code equals 200.
     */
    public function testLoginAction()
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
