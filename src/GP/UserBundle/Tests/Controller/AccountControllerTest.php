<?php
/**
 * Created by PhpStorm.
 * User: robin
 * Date: 22/11/15
 * Time: 23:43
 */

namespace GP\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Unit testing for the Dashboard controller
 *
 * @package GP\UserBundle\Tests\Controller
 */
class AccountControllerTest extends WebTestCase
{

    /**
     * Unit testing the indexAction function
     */
    public function testShowAccountAction()
    {
        $client = static::createClient();

        $client->request('GET', '/secure/account');

        // Assert that the response status code is 3xx
        $this->assertTrue($client->getResponse()->isRedirection());
    }
}