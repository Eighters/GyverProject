<?php

namespace GyverBundle\Tests\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class UserManagementControllerTest
 *
 * Unit testing for the SettingsController
 *
 * @package GyverBundle\Tests\Controller\Admin
 */
class UserManagementControllerTest extends WebTestCase
{
    public function testIndexAction()
    {
        $client = static::createClient();
        $client->request('GET', '/secure/user');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}
