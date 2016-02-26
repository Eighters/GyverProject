<?php

namespace GP\SecurityBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use GP\CoreBundle\Tests\BaseTestCase;
/**
 * Unit testing for the Password controller
 *
 * @package GP\SecurityBundle\Tests\Controller
 */
class ResettingControllerTest extends BaseTestCase
{

    /**
     * Test valid request change password
     */
    public function testRequestChangePasswordAction()
    {
        $client = static::createClient();
        $client->enableProfiler();

        $this->application_name = ucfirst($client->getKernel()->getContainer()->getParameter('application_name'));

        $url = $this->generateRoute($client, 'fos_user_resetting_request');
        $crawler = $client->request('GET', $url);

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'A non logged user should see the request change password page');

        $data = array(
            'username'  => 'gauvin.thibaut83+gyver-project@gmail.com'
        );

        $form = $crawler->selectButton('_submit')->form($data);

        $client->submit($form);

        // Check that an email was sent
        $mailCollector = $client->getProfile()->getCollector('swiftmailer');
        $this->assertEquals(1, $mailCollector->getMessageCount());

        // Asserting email data
        $collectedMessages = $mailCollector->getMessages();
        $message = $collectedMessages[0];
        $this->assertInstanceOf('Swift_Message', $message);
        $this->assertEquals('['.$this->application_name.' Project] | Demande de réinitialisation de mot de passe', $message->getSubject());
        $this->assertEquals('gyver.project@gmail.com', key($message->getFrom()));
        $this->assertEquals('gauvin.thibaut83+gyver-project@gmail.com', key($message->getTo()));

        // Check Html
        $client->followRedirect();
//        $this->assertHtmlContains(
//            $crawler,
//            'checkEmail',
//            'A User who submit a valid user request change password should see a confirmation message'
//        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'A non logged user should see the confirmation page after submit a change password request');
    }

}
