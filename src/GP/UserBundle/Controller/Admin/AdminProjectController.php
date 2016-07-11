<?php

namespace GP\UserBundle\Controller\Admin;

use GP\CoreBundle\Entity\Company;
use GP\CoreBundle\Entity\Project;
use GP\UserBundle\Form\Type\Admin\CreateProjectType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class Admin Project Controller
 * @package GP\UserBundle\Controller
 *
 * @Route("/secure/admin/project")
 */
class AdminProjectController extends Controller
{
    /**
     * Returns the list of projects registered in the application
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
     * Create new project
     *
     * @Route("/new", name="admin_create_project")
     * @Method("GET|POST")
     * @Template("GPUserBundle:Admin/Project:createProject.html.twig")
     */
    public function createProjectAction(Request $request)
    {
        $project = new Project();
        $form = $this->createForm(new CreateProjectType(), $project);

        $form->handleRequest($request);
        if ($form->isValid()) {
            // The relation between Company & project is a ManyToMany owning by company, We already check that company exist in ProjectValidator
            /** @var Company $company */
            $company = $form->get('companies')->getData();
            $company->addProject($project);

            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->persist($project);
            $em->flush();

            $logger = $this->get('monolog.logger.user_access');
            $logger->alert('[PROJECT_CREATION] ' . $this->getUser()->getEmail() .' have created new project : '. $project->getName());

            $this->addFlash('success', 'Le projet '. $project->getName() .' a été correctement crée');
            return $this->redirectToRoute('admin_show_project', array('id' => $project->getId()));
        }

        return array(
            'form' => $form->createView()
        );
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

    /**
     * Display full data of given project
     *
     * @Route("/{id}", name="admin_delete_project")
     * @Method("DELETE")
     */
    public function deleteProjectAction($id)
    {
        // Searching requested project
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository('GPCoreBundle:Project')->find($id);

        // Checking if project exists
        if (!$project) {
            $this->addFlash('error', 'Projet introuvable');
            return $this->redirectToRoute('admin_show_all_project');
        }

        $em->remove($project);
        $em->flush();

        $logger = $this->get('monolog.logger.user_access');
        $logger->alert('[PROJECT_DELETION] ' . $this->getUser()->getEmail() .' have deleted project : '. $project->getName());

        $this->addFlash('error', 'Le projet a été supprimé avec succès');
        return $this->redirectToRoute('admin_show_all_project');
    }
}
