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
class LoginControllerTest extends WebTestCase
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

    /**
     * test adminLoginForm
     */
    public function testAdminLoginForm()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form();

        $client->submit($form, array(
            '_username' => 'admin',
            '_password' => 'password',
        ));

        // redir validation
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $client->followRedirect();

        // Redir vers /secure
        $this->assertEquals(301, $client->getResponse()->getStatusCode());
    }

}
