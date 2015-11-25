<?php

namespace GP\SecurityBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use GP\SecurityBundle\Controller\PasswordController;

/**
 * Unit testing for the Password controller
 *
 * @package GP\SecurityBundle\Tests\Controller
 */
class PasswordControllerTest extends WebTestCase
{

    /**
     * Unit testing the checkUserPasswordAction function
     */
    public function testCheckUserPasswordAction()
    {
        $client = static::createClient();

        $client->request("POST", "/secure/password/check");

        // Assert that the response status code is 3xx
        $this->assertTrue($client->getResponse()->isRedirection());
    }

    /**
     * Unit testing the encryptPasswordAction function
     */
    public function testEncryptPasswordAction()
    {
        // Initialize parameters
        $password = "password";
        $salt = "ajsdqew2drsw0ggss0k0gs4gw4wgwcw";
        $expectedResult = "jWV51iizX2+qwWLLya+eXImJ9wwWw0CCHi4yW9STBFcn6lLEv7r2f1cpRxbnBQtRoP/8pozVXNcrOdu3L+iv5Q==";

        // Reflect the private method to public
        $instance = new PasswordController();
        $method = new \ReflectionMethod('GP\SecurityBundle\Controller\PasswordController', 'encryptPassword');
        $method->setAccessible(true);

        $encryptedPassword = $method->invokeArgs($instance, array( $password, $salt ) );

        // Assert that the password has been correctly encrypted
        $this->assertTrue($encryptedPassword == $expectedResult);
    }
}