<?php

namespace GP\UserBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use GP\CoreBundle\Entity\Invitation;
use GP\UserBundle\Form\Type\Admin\SendInvitationType;

/**
 * Class Admin Invitation Controller
 * @package GP\UserBundle\Controller
 *
 * @Route("/secure/admin")
 */
class AdminInvitationController extends Controller
{
    /**
     * Invite a new user in the application
     *
     * @Route("/invitation/new", name="admin_invitation_new")
     * @Method("GET|POST")
     * @Template("GPUserBundle:Admin/User:inviteUser.html.twig")
     */
    public function inviteUserAction(Request $request)
    {
        $invitation = new Invitation();
        $form = $this->createForm(new SendInvitationType(), $invitation);

        $form->handleRequest($request);
        if ($form->isValid()) {
            // check if they already have an invitation in progress for the given Email
            $repository = $this->getDoctrine()->getRepository('GPCoreBundle:Invitation');
            $olderInvitation = $repository->findByEmail($invitation->getEmail());

            if ($olderInvitation) {
                $this->addFlash('error', 'Erreur, Une invitation est déjà en cours pour l\'adresse: ' . $invitation->getEmail());
                return $this->redirectToRoute('admin_invitation_new');
            } else {
                $invitation->send();

                $em = $this->getDoctrine()->getManager();
                $em->persist($invitation);
                $em->flush();

                // Notice him by email
                $mailerService = $this->get('gp.core_bundle.mailing_service');
                $mailerService->sendUserInvitationNotification($invitation);

                // Log the invitation
                $logger = $this->get('monolog.logger.user_access');
                $logger->alert('[INVITATION] ' . $this->getUser()->getEmail() .' have sent new invitation to '. $invitation->getEmail());

                $this->addFlash('success', 'Une invitation a été envoyée à l\'adresse: ' . $invitation->getEmail());
                return $this->redirect($this->generateUrl('admin_show_all_user'));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * Show all Invitations
     *
     * @Route("/invitation/show", name="admin_show_invitation")
     * @Method("GET")
     * @Template("GPUserBundle:Admin/User:showInvitation.html.twig")
     */
    public function showInvitationAction(Request $request)
    {
        $invitationRepository = $this->getDoctrine()->getRepository('GPCoreBundle:Invitation');
        $invitations = $invitationRepository->findAllInvitationAndOrderByDate();

        $pagination = $this->get('knp_paginator')->paginate(
            $invitations,
            $request->query->getInt('page', 1),
            $this->container->getParameter( 'knp_paginator.page_range' )
        );

        return array('pagination' => $pagination);
    }

    /**
     * Show all Invitations
     *
     * @Route("/invitation/delete", name="admin_delete_invitation")
     * @Method("GET")
     * @Template("GPUserBundle:Admin/User:showInvitation.html.twig")
     */
    public function deleteInvitationAction(Request $request)
    {
        $this->addFlash('notice', 'feature en cours de developpement');
        return $this->redirectToRoute('admin_show_invitation');
    }
}
