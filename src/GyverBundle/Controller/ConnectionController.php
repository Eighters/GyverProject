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
     * Login view render and authentication function.
     *
     * @param Request $request
     * @return render
     *
     * @Route("/login", name="login_form")
     * @Method("GET|POST")
     */
    public function renderConnectionFormAction(Request $request)
    {
        // Verify if user is already authenticated
        $session = $request->getSession();
        if(!$session->has("user")) {

            // User not connected, creating the login form.
            $form = $this->createFormBuilder(new User())
                ->add('email', 'email')
                ->add('password', 'password')
                ->add('Connexion', 'submit', array('label' => 'Login'))
                ->getForm();
            // Listening for login request
            $form->handleRequest($request);

            /*
             * Checking if the login form is valid
             * If valid, checking params validity.
             */
            if ($form->isValid()) {
                $user = $this->authenticateUser($form->get('email')->getData(), $form->get('password')->getData());

                /*
                 * If user exists, creating session and redirect to dashboard.
                 * Else, return an error message
                 */
                if ($user) {
                    $session->set("user", $user);
                    $session->getFlashBag()->add("success", "User connected");
                    return $this->render('default/index.html.twig');
                } else
                    $session->getFlashBag()->add("error", "Identifiant ou mot de passe invalide !");
            }

            // Rendering login form by default
            return $this->render('connection/form_login.html.twig', array(
                'form' => $form->createView()
            ));
        }

        // User already authenticated, redirect him to his dashboard
        return $this->render('default/index.html.twig');
    }

    /**
     * Authenticate a user with is email and password.
     * Checking if the user exists in database.
     * If user exists return the User object, else return null.
     *
     * @param $email
     * @param $password
     * @return User
     */
    private function authenticateUser($email, $password)
    {
        // Initialize user
        $user = null;

        // Searching for the user
        try {
            $userRepository = $this->getDoctrine()->getRepository('GyverBundle:User');
            $user = $userRepository->findOneBy(
                array("email" => $email, "password" => $password)
            );
        } catch (Exception $e) {
            ThrowException($e);
        }

        // Return user
        return $user;
    }


}
