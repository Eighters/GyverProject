<?php

namespace GyverBundle\Tests\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserManagementControllerTest extends WebTestCase
{
    /**
     * readAction method test
     * - Assert if the returned status code equals 200.
     */
    public function testReadAction()
    {
        $client = static::createClient();
        $client->request('GET', '/secure/account');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testShowuser()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'jWV51iizX2+qwWLLya+eXImJ9wwWw0CCHi4yW9STBFcn6lLEv7r2f1cpRxbnBQtRoP/8pozVXNcrOdu3L+iv5Q==',));

        $client->followRedirects();

        $crawler = $client->request('GET', '/secure/user/16');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testColleage()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'thibaut',
            'PHP_AUTH_PW'   => 'jWV51iizX2+qwWLLya+eXImJ9wwWw0CCHi4yW9STBFcn6lLEv7r2f1cpRxbnBQtRoP/8pozVXNcrOdu3L+iv5Q==',));

        $client->followRedirects();


        $crawler = $client->request('GET', '/secure/colleage/8');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}