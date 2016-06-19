<?php

namespace GP\UserBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class Admin Project Controller
 * @package GP\UserBundle\Controller
 *
 * @Route("/secure/admin/project")
 */
class AdminProjectController extends Controller
{
    /**
     * Returns the list of companies registered in the application
     *
     * @Route("/", name="admin_show_all_project")
     * @Method("GET")
     * @Template("GPUserBundle:Admin/Project:showProjects.html.twig")
     */
    public function showProjectsAction(Request $request)
    {
        // Getting all project
        $em = $this->getDoctrine()->getManager();
        $projects = $em->getRepository('GPCoreBundle:Project')->findAll();

        // Create a pagination
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $projects,
            $request->query->getInt('page', 1),
            $this->container->getParameter( 'knp_paginator.page_range' )
        );

        return array('pagination' => $pagination);
    }

    /**
     * Display full data of given project
     *
     * @Route("/{id}", name="admin_show_project")
     * @Method("GET")
     * @Template("GPUserBundle:Admin/Project:showProject.html.twig")
     */
    public function showProjectAction($id)
    {
        // Searching requested project
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository('GPCoreBundle:Project')->find($id);

        // Checking if project exists
        if (!$project) {
            $this->addFlash('error', 'Projet introuvable');
            return $this->redirectToRoute('admin_show_all_project');
        }

        return array('project' => $project);
    }
}
