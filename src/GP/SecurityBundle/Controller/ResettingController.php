<?php

namespace GP\SecurityBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use FOS\UserBundle\Controller\ResettingController as FOSResettingController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;

/**
 * Reset user password
 *
 * @package GP\SecurityBundle\Controller
 */
class ResettingController extends FOSResettingController
{
    /**
     * Override of the FOSUserBundle reset password function.
     *
     * Reset user password
     *
     * @Route("/login", name="login")
     * @Method("GET")
     * @Template()
     */
    public function resetAction(Request $request, $token)
    {
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.resetting.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with "confirmation token" does not exist for value "%s"', $token));
        }

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::RESETTING_RESET_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::RESETTING_RESET_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $this->addFlash('success', 'Votre mot de passe a bien été mis à jour');
                $response = $this->redirectToRoute('dashboard');
            }

            $dispatcher->dispatch(FOSUserEvents::RESETTING_RESET_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('FOSUserBundle:Resetting:reset.html.twig', array(
            'token' => $token,
            'form' => $form->createView(),
        ));
    }
}
