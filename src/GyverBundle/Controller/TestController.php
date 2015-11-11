<?php

namespace GyverBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TestController extends Controller
{
    /**
     * Return Home Page
     *
     * @Route("/test/index", name="index_test_page")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        return $this->render('Default/testPage.html.twig');
    }

    /**
     * Send a test email
     *
     * @Route("/test/email", name="test_email")
     * @Method("GET")
     */
    public function sendEmailAction(Request $request)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('New Event From Gyver Project')
            ->setFrom('Notifications@GyverProject.com')
            ->setTo('gauvin.thibaut83@gmail.com')
            ->setBody($this->renderView('Email/email.txt.twig'));
        $message->setContentType("text/html");
        $this->get('mailer')->send($message);

        $this->addFlash(
            'success',
            'Your message has been successfully send \O/ visit localhost:1080 to see it'
        );

        return $this->redirect($this->generateUrl('index_test_page'));
    }

    /**
     * Test Flash Message
     *
     * @Route("/test/flash/{type}", name="test_flash_message")
     * @Method("GET")
     */
    public function testFlashAction(Request $request, $type)
    {
        $this->addFlash(
            $type,
            ucfirst($type) . ' Flash Message Sample'
        );

        return $this->render('Default/testPage.html.twig');
    }

    /**
     * test db
     *
     * @Route("/test/db", name="test_db")
     * @Method("GET")
     */
    public function testDbAction(Request $request)
    {
        $userRepository = $this->getDoctrine()->getRepository('GyverBundle:User');
        $userRepository->findAll();

        return $this->render('Default/user.html.twig');
    }

    /**
     * test pop user db
     *
     * @Route("/test/user", name="test_pop_db")
     * @Method("GET")
     */
    public function popUserDbAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setFirstName('thibaut');
        $user->setLastName('gauvin');
        $user->setPassword('pass');
        $user->setSalt('salt');
        $user->setEmail('thibaut@test.fr');
        $user->setPhone('0123456789');

        $em->persist($user);
        $em->flush();
    }
}
