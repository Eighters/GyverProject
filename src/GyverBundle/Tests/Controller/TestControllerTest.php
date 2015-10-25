<?php

namespace GyverBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/test/index');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testEmailSend()
    {
        $client = static::createClient();
        $client->enableProfiler();

        $client->request('GET', '/test/email');

        $mailCollector = $client->getProfile()->getCollector('swiftmailer');

        // Check that an email was sent
        $this->assertEquals(1, $mailCollector->getMessageCount());

        $collectedMessages = $mailCollector->getMessages();
        $message = $collectedMessages[0];

        // Asserting email data
        $this->assertInstanceOf('Swift_Message', $message);
        $this->assertEquals('New Event From Gyver Project', $message->getSubject());
        $this->assertEquals('Notifications@GyverProject.com', key($message->getFrom()));
        $this->assertEquals('gauvin.thibaut83@gmail.com', key($message->getTo()));
//        $this->assertEquals(
//            'New Event From Gyver Project',
//            $message->getBody()
//        );

        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @dataProvider flashMessageProvider
     *
     * @param array $data
     * @param array $message
     */
    public function testFlashMessage(array $data, array $message)
    {
        $client = static::createClient();
        $client->request('GET', '/test/flash/'.$data[0]);

        $this->assertEquals(1, $client->getCrawler()->filter('.alert-box:contains(' . $message[0] . ')')->count());
    }

    public function flashMessageProvider()
    {
        return array(
            // Success
            array(
                'data' => array(
                    'success',
                ),
                'message' => array(
                    'Success Flash Message Sample',
                ),
            ),

            // Notice
            array(
                'data' => array(
                    'notice',
                ),
                'message' => array(
                    'Notice Flash Message Sample',
                ),
            ),

            // Error
            array(
                'data' => array(
                    'error',
                ),
                'message' => array(
                    'Error Flash Message Sample',
                ),
            ),
        );
    }
}
