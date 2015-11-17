<?php

namespace GyverBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class UserController
 * @package GyverBundle\Controller\User
 *
 * @Route("/secure")
 */

class UserController extends Controller
{

    /**
     * @param $id
     * @Route("/account/{id}", requirements={"id" = "\d+"}, name="user_info")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function readAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('GyverBundle:User')->findOneById($id);


        return $this->render(':User:form_informations.html.twig', array('user' => $user ));
    }


    /**
     * @Route("/user/{id}")
     * @Method("GET")
     * @Template()
     */
    public function showUserAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('GyverBundle:User')->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }


        return array(
            'user' => $user,
        );
    }

}
