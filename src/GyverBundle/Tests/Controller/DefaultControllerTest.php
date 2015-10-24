<?php

namespace GyverBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testTestPage()
    {
        $client = static::createClient();
        $client->request('GET', '/test');
        $this->assertEquals(301, $client->getResponse()->getStatusCode());

        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
