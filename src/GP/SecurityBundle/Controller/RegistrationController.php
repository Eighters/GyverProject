<?php

namespace GP\SecurityBundle\Controller;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use GP\CoreBundle\Entity\Invitation;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controller managing the registration
 *
 * @package GP\SecurityBundle\Controller
 */
class RegistrationController extends Controller
{
    /**
     * Override of the FOSUserBundle reset password function.
     *
     * Reset user password
     *
     * @Route("/register/{token}", name="register")
     * @Method("GET|POST")
     * @Template()
     */
    public function registerAction(Request $request, $token)
    {
        $repository = $this->getDoctrine()->getRepository('GPCoreBundle:Invitation');
        $invitation = $repository->findOneByConfirmationToken($token);

        if(!$invitation) {
            throw new NotFoundHttpException("Invitation not found");
        }

        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setEnabled(true);
        $user->setEmail($invitation->getEmail());
        $user->setInvitation($invitation);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher = $this->get('event_dispatcher');
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $formFactory = $this->get('fos_user.registration.form.factory');
        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $this->addFlash('success', 'Votre compte a bien été créé');
                $this->updateInvitationStatus($invitation);

                // Log the registration
                $logger = $this->get('monolog.logger.user_access');
                $logger->alert('[SIGNUP] ' . $user->getEmail() .' have successfully Signed Up with Invitation ID No°' . $user->getInvitation()->getCode());

                $response = new RedirectResponse($this->generateUrl('login'));
            }

            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('FOSUserBundle:Registration:register.html.twig', array(
            'form' => $form->createView(),
            'token' => $invitation->getConfirmationToken()
        ));
    }

    private function updateInvitationStatus(Invitation $invitation)
    {
        $invitation->setStatus(Invitation::STATUS_ACCEPTED);

        $em = $this->getDoctrine()->getManager();
        $em->persist($invitation);
        $em->flush();
    }
}
