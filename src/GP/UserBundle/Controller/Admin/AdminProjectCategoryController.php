<?php

namespace GP\UserBundle\Controller\Admin;

use GP\CoreBundle\Entity\ProjectCategory;
use GP\UserBundle\Form\Type\Admin\NewProjectCategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class Admin Project Category Controller
 * @package GP\UserBundle\Controller
 *
 * @Route("/secure/admin/project/category")
 */
class AdminProjectCategoryController extends Controller
{

    /**
     * Returns the list of all project categories
     *
     * @Route("/", name="admin_show_all_project_categories")
     * @Method("GET")
     * @Template("GPUserBundle:Admin/Project/Category:showProjectCategories.html.twig")
     */
    public function showProjectCategoriesAction(Request $request)
    {
        // Getting all project categories
        $em = $this->getDoctrine()->getManager();
        $projectCategories = $em->getRepository('GPCoreBundle:ProjectCategory')->findAll();

        // Create a pagination
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $projectCategories,
            $request->query->getInt('page', 1),
            $this->container->getParameter( 'knp_paginator.page_range' )
        );

        return array('pagination' => $pagination);
    }

    /**
     * Create new project category
     *
     * @Route("/new", name="admin_create_project_category")
     * @Method("GET|POST")
     * @Template("GPUserBundle:Admin/Project/Category:createProjectCategory.html.twig")
     */
    public function createProjectCategoryAction(Request $request)
    {
        $projectCategory = new ProjectCategory();
        $form = $this->createForm(new NewProjectCategoryType(), $projectCategory);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($projectCategory);
            $em->flush();

            // Return success message
            $this->addFlash('success', 'La catégorie '. $projectCategory->getName() .' a été correctement crée');
            return $this->redirectToRoute('admin_show_all_project_categories');
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * Delete a given project category
     *
     * @Route("/{id}/delete", name="admin_delete_project_category")
     * @Method("GET|DELETE")
     */
    public function deleteProjectCategoryAction(Request $request, $id)
    {
        // Searching requested Project Category
        $em = $this->getDoctrine()->getManager();
        $projectCategory = $em->getRepository('GPCoreBundle:ProjectCategory')->find($id);

        // Checking if Project Category
        if (!$projectCategory) {
            $this->addFlash('error', 'La catégorie de projet est introuvable');
            return $this->redirectToRoute('admin_show_all_project_categories');
        }

        // Removing the Project Category
        $em->remove($projectCategory);
        $em->flush();

        // Return success message
        $this->addFlash('success', 'La catégorie de projet '. $projectCategory->getName() .' a été correctement supprimé');
        return $this->redirectToRoute('admin_show_all_project_categories');
    }
}
