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
        $client->request('GET', '/secure/account/6');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}
