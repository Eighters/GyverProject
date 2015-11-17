<?php

namespace GyverBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GyverBundle\Entity\User;

/**
 * @Route("/secure/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/{id}")
     * @Template()
     */
    public function showUserAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('GyverBundle:User')->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        //$deleteForm = $this->createDeleteForm($id);

        return array(
            'user' => $user,
            //'delete_form' => $deleteForm->createView(),
        );
    }

}
