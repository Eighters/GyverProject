<?php

namespace GyverBundle\Tests\Controller\Settings;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class SettingsControllerTest
 *
 * Unit testing for the SettingsController
 *
 * @package GyverBundle\Tests\Controller\Settings
 */
class SettingsControllerTest extends WebTestCase
{
    /**
     * homeAction method test
     * - Assert if the returned status code equals 200.
     */
    public function testHomeAction()
    {
        $client = static::createClient();
        $client->request('GET', '/backend');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
