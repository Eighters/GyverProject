<?php

namespace GyverBundle\Controller;

use GyverBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * Return Home Page
     *
     * @Route("/", name="front_homepage")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * Return test page
     *
     * @Route("/test", name="test_page")
     * @Method("GET")
     */
    public function testPageAction(Request $request)
    {
        return $this->redirectToRoute('index_test_page', array(), 301);
    }

    /**
     * test db
     *
     * @Route("/test/db", name="test_db")
     * @Method("GET")
     */
    public function testDb(Request $request)
    {
        var_dump('fzeighoe'); die;
        $userRepository = $this->getDoctrine()->getRepository('GyverBundle:User');
        $users = $userRepository->findAll();


        return $this->render('default/user.html.twig');
    }

    /**
     * test pop user db
     *
     * @Route("/test/user", name="test_pop_db")
     * @Method("GET")
     */
    public function popUserDb(Request $request)
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
