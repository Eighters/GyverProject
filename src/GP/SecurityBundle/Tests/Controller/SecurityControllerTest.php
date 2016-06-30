<?php

namespace GP\SecurityBundle\Tests\Controller;

use GP\CoreBundle\Tests\BaseTestCase;

/**
 * Unit testing for the Security controller
 *
 * @package GP\SecurityBundle\Tests\Controller
 */
class SecurityControllerTest extends BaseTestCase
{

    /**
     * Unit testing the indexAction function
     */
    public function testIndexAction()
    {
        $client = static::createClient();

        $client->request("GET", "/");

        // Assert that the response status code is 3xx
        $this->assertTrue($client->getResponse()->isRedirection());

        // Follow the redirection to the login action
        $client->followRedirect();

        // Assert that the response status code is 2xx
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * Unit testing the loginAction function
     */
    public function testLoginAction()
    {
        $client = static::createClient();

        $client->request('GET', '/login');

        // Assert that the response status code is 2xx
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * Test success login form
     */
    public function testValidLoginForm()
    {
        $client = static::createClient();

        $url = $this->generateRoute('login');
        $crawler = $client->request('GET', $url);

        $credentials = array(
            '_username'  => self::USER_DEVELOPPEUR,
            '_password'  => self::USER_PASSWORD,
        );

        $form = $crawler->selectButton('_submit')->form($credentials);
        $client->submit($form);

        $this->assertStatusCode(302, $client);
    }

    /**
     * Test errors on login form
     */
    public function testInvalidLoginForm()
    {
        $client = static::createClient();

        $url = $this->generateRoute('login');
        $crawler = $client->request('GET', $url);

        $credentials = array(
            '_username'  => 'toto',
            '_password'  => 'toto',
        );

        $form = $crawler->selectButton('_submit')->form($credentials);
        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertHtmlContains($crawler, 'Invalid credentials.' , 'User should see error message when he submit invalid credentials');
    }
}
