<?php

namespace GyverBundle\Controller;

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
}
