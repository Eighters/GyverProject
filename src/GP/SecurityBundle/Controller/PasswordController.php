<?php

namespace GP\SecurityBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Password manager for the Gyver Project application
 * This manager is available only for authenticated users
 *
 * @package GP\SecurityBundle\Controller
 *
 * @Route("/secure/password")
 */
class PasswordController extends Controller
{

    /**
     * Allow to check the password of the current user
     *
     * @Route("/check", name="check_password")
     * @Method("POST")
     */
    public function checkUserPassword()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $encryptedPassword = $this->encryptPassword(
            $this->get('request')->get('password'),
            $user->getSalt()
        );

        if($encryptedPassword == $user->getPassword()) {
            return new Response(json_encode(true));
        } else {
            return new Response(json_encode(false));
        }
    }

    /**
     * Encrypt a password with a specific salt
     *
     * @param $password
     * @param $salt
     * @return string
     */
    private function encryptPassword($password, $salt)
    {
        $salted = $password . '{' . $salt . '}';
        $digest = hash('sha512', $salted, true);

        for($i = 1 ; $i < 5000 ; $i++) {
            $digest = hash('sha512', $digest.$salted, true);
        }

        $encryptedPassword = base64_encode($digest);

        return $encryptedPassword;
    }
}