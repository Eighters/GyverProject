<?php

namespace GP\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class ProjectController
 * @package GP\ProjectBundle\Controller
 *
 * @Route("/secure/project")
 */
class ProjectController extends Controller
{
    /**
     * Show all project (associated to the given user => not yet)
     *
     * @Route("/", name="show_all_projects")
     * @Method("GET")
     * @Template("GPProjectBundle:Project:showProjects.html.twig")
     */
    public function showProjectsAction()
    {
        // Getting all projects for the current User
        $em = $this->getDoctrine()->getManager();
        $projects = $em->getRepository('GPCoreBundle:Project')->findUserProjects($this->getUser());

        return array('projects' => $projects);
    }

    /**
     * Display projects data
     *
     * @Route("/{id}", name="show_project")
     * @Method("GET")
     * @Template("GPProjectBundle:Project:showProject.html.twig")
     */
    public function showProjectAction($id)
    {
        // Searching requested project
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository('GPCoreBundle:Project')->find($id);

        // Checking if project exists
        if (!$project) {
            $this->addFlash('error', 'Projet introuvable');
            return $this->redirectToRoute('show_all_projects');
        }

        // Check if user have right to view company data
        if (!$project->checkUserAccess($this->getUser()) && !$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') ) {
            throw new AccessDeniedException();
        }

        return array('project' => $project);
    }
}
