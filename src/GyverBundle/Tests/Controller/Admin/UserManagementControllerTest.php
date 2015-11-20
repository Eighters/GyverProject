<?php

namespace GyverBundle\Tests\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * UserManagementController Unit Testing
 *
 * @package GyverBundle\Tests\Controller\Admin
 */
class UserManagementControllerTest extends WebTestCase
{
    /**
     * readAction method test
     * - Assert if the returned status code equals 200.
     */
    public function testIndexAction()
    {
        $client = static::createClient();
        $client->request('GET', '/secure/user/page/1');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    /**
     * Test showUserAction
     */
    public function testShowUserAction()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'jWV51iizX2+qwWLLya+eXImJ9wwWw0CCHi4yW9STBFcn6lLEv7r2f1cpRxbnBQtRoP/8pozVXNcrOdu3L+iv5Q==',));

        $client->followRedirects();

        $crawler = $client->request('GET', '/secure/user/16');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * Test colleageAction
     */
    public function testColleageAction()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'thibaut',
            'PHP_AUTH_PW'   => 'jWV51iizX2+qwWLLya+eXImJ9wwWw0CCHi4yW9STBFcn6lLEv7r2f1cpRxbnBQtRoP/8pozVXNcrOdu3L+iv5Q==',));

        $client->followRedirects();


        $crawler = $client->request('GET', '/secure/colleage/8');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}
