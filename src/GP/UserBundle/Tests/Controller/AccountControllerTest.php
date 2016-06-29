<?php

namespace GP\UserBundle\Tests\Controller;

use GP\CoreBundle\Tests\BaseTestCase;

/**
 * Unit testing for the Dashboard controller
 *
 * @package GP\UserBundle\Tests\Controller
 */
class AccountControllerTest extends BaseTestCase
{
    /**
     * Test user can see her account page
     *
     * @dataProvider userProvider
     *
     * @param $userName
     * @param $password
     * @param $expectedStatusCode
     * @param $message
     */
    public function testAccessShowAccount($userName, $password, $expectedStatusCode, $message)
    {
        $client = $this->connectUser($userName, $password);

        $url = $this->generateRoute('show_account');
        $client->request('GET', $url);

        $this->assertEquals($expectedStatusCode, $client->getResponse()->getStatusCode(), $message);
    }

    public function userProvider()
    {
        return array (
            array(
                'userName' => 'admin',
                'password' => self::USER_PASSWORD,
                'expectedStatusCode' => '200',
                'message' => 'An admin user should see her account homepage',
            ),
            array(
                'userName' => 'thibaut',
                'password' => self::USER_PASSWORD,
                'expectedStatusCode' => '200',
                'message' => 'An regular user should see her account homepage',
            ),
        );
    }

    /**
     * Unit testing the showAccountAction function
     */
    public function testShowAccountAction()
    {
        $client = static::createClient();

        $client->request('GET', '/secure/account');

        // Assert that the response status code is 3xx
        $this->assertTrue($client->getResponse()->isRedirection());
    }

    /**
     * Unit testing the editAccountAction function
     */
    public function testAccessEditAccountAction()
    {
        $client = static::createClient();

        $client->request('GET', '/secure/account/edit');

        // Assert that the response status code is 3xx
        $this->assertTrue($client->getResponse()->isRedirection());
    }

    /**
     * test success edit of user account infos
     */
    public function testSuccessEditAccountAction()
    {
        $client = $this->connectUser(self::USER_CLIENT, self::USER_PASSWORD);

        $url = $this->generateRoute('edit_account');
        $crawler = $client->request('GET', $url);
        $this->assertStatusCode(200, $client);

        $form = $crawler->selectButton('_submit')->form();

        $form["fos_user_profile_form[civility]"]->select('male');

        $crawler = $client->submit($form, array(
            "fos_user_profile_form[firstName]" => "Roberto",
            "fos_user_profile_form[lastName]" => "Ramos",
            "fos_user_profile_form[email]" => "gyver.project+client@gmail.com",
            "fos_user_profile_form[current_password]" => "password"
        ));

        $this->assertStatusCode(200, $client);
        $this->assertFlashMessageContains($crawler, 'profile.flash.updated', 'a user should see confirmation flassmessage when update personnal account infos');
    }
}
