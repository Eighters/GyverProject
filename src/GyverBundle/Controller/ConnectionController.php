<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 09/11/15
 * Time: 16:21
 */

namespace GyverBundle\Controller;

use GyverBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Tests\User\UserTest;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class ConnectionController
 * @package GyverBundle\Controller
 *
 * Controller to manage users connection
 *
 */
class ConnectionController extends Controller
{

    /**
     * @param Request $request
     *
     * @Route("/login", name="login_form")
     * @Method("GET|POST")
     */

    public function renderConnectionFormAction(Request $request)
    {
        $session = $request->getSession();
        if(!$session->has("user")) {

            $user = new User();
            $form = $this->createFormBuilder($user)
                ->add('email', 'email')
                ->add('password', 'password')
                ->add('Connexion', 'submit', array('label' => 'Login'))
                ->getForm();

            $form->handleRequest($request);

            if ($form->isValid()) {
                $email = $form->get('email')->getData();
                $password = $form->get('password')->getData();

                try {
                    $userRepository = $this->getDoctrine()->getRepository('GyverBundle:User');
                    $user = $userRepository->findOneBy(
                        array("email" => $email, "password" => $password)
                    );
                } catch (Exception $e) {
                    ThrowException($e);
                }

                if ($user) {

                    $session->set("user", $user);
                    $session->getFlashBag()->add("success", "User connected");
                    return $this->render('default/index.html.twig');
                } else
                    $session->getFlashBag()->add("error", "Identifiant ou mot de passe invalide !");
            }

            return $this->render('connection/form_login.html.twig', array(
                'form' => $form->createView()
            ));

        }

        return $this->render('default/index.html.twig');

    }



}