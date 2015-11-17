<?php

namespace GyverBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
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

        $crawler = $client->request('GET', '/secure/user/16');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

}
