<?php

namespace GyverBundle\Controller\Settings;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class SettingsController
 * @package GyverBundle\Controller\Settings
 *
 * @Route("/secure")
 */
class SettingsController extends Controller
{

    /**
     * Render Form update user profile
     *
     * @Route("/account", name="user_info")
     * @Method("GET")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function readAction()
    {
        //To get the user who is logged
        $user = $this->get('security.token_storage')->getToken()->getUser();

        return $this->render(':User:form_informations.html.twig', array('user' => $user ));
    }

    /**
     * @Route("/account/edit", name="user_edit")
     * @Method("GET|POST")
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface)
            throw new AccessDeniedException('This user does not have access to this section.');

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse())
            return $event->getResponse();

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.profile.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid())
            $this->validateEditAction($form, $request, $dispatcher, $user);

        return $this->render('FOSUserBundle:Profile:edit_content.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Validate edit action
     *
     * @param $form
     * @param $request
     * @param $dispatcher
     * @param $user
     * @return null|RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    private function validateEditAction($form, $request, $dispatcher, $user)
    {
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');

        $event = new FormEvent($form, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

        $userManager->updateUser($user);

        if (null === $response = $event->getResponse()) {
            $url = $this->generateUrl('user_info');
            $response = new RedirectResponse($url);
        }

        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

        return $response;
    }

}
