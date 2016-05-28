<?php

namespace GP\UserBundle\Controller\Admin;

use GP\CoreBundle\Entity\Company;
use GP\UserBundle\Form\Type\Admin\NewCompanyType;
use GP\UserBundle\Form\Type\Admin\addUserToCompanyType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class Admin Company Controller
 * @package GP\UserBundle\Controller
 *
 * @Route("/secure/admin/company")
 */
class AdminCompanyController extends Controller
{
    /**
     * Create a new company
     *
     * @Route("/new", name="admin_create_company")
     * @Method("GET|POST")
     * @Template("GPUserBundle:Admin/Company:createCompany.html.twig")
     */
    public function createCompanyAction(Request $request)
    {
        $company = new Company();
        $form = $this->createForm(new NewCompanyType(), $company);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($company);
            $em->flush();

            $this->addFlash('success', 'L\'entreprise '. $company->getName() .' a été correctement crée');
            return $this->redirectToRoute('admin_show_all_company');
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * Returns the list of companies registered in the application
     *
     * @Route("/", name="admin_show_all_company")
     * @Method("GET")
     * @Template("GPUserBundle:Admin/Company:showCompanies.html.twig")
     */
    public function showCompaniesAction(Request $request)
    {
        // Getting all companies
        $em = $this->getDoctrine()->getManager();
        $companies = $em->getRepository('GPCoreBundle:Company')->findAll();

        // Create a pagination
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $companies,
            $request->query->getInt('page', 1),
            $this->container->getParameter( 'knp_paginator.page_range' )
        );

        return array('pagination' => $pagination);
    }

    /**
     * Display full data of a given company
     *
     * @Route("/{id}", name="admin_show_company")
     * @Method("GET")
     * @Template("GPUserBundle:Admin/Company:showCompany.html.twig")
     */
    public function showCompanyAction($id)
    {
        // Searching requested company
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('GPCoreBundle:Company')->find($id);

        // Checking if company exists
        if (!$company) {
            $this->addFlash('error', 'Entreprise introuvable');
            return $this->redirectToRoute('admin_show_all_company');
        }

        $projectRepository = $this->getDoctrine()->getRepository('GPCoreBundle:Project');
        $finishedProject = $projectRepository->countFinishedProjects($company);
        $inProgressProjectNb = $projectRepository->countProjectsInProgress($company);

        return array(
            'company' => $company,
            'finishedProjectNb' => $finishedProject,
            'inProgressProjectNb' => $inProgressProjectNb
        );
    }

    /**
     * Update a given company
     *
     * @Route("/{id}/edit", name="admin_update_company")
     * @Method("GET|POST")
     * @Template("GPUserBundle:Admin/Company:updateCompany.html.twig")
     */
    public function updateCompanyAction(Request $request, $id)
    {
        // Searching requested company
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('GPCoreBundle:Company')->find($id);

        // Checking if company exists
        if (!$company) {
            $this->addFlash('error', 'Entreprise introuvable');
            return $this->redirectToRoute('admin_show_all_company');
        }

        $form = $this->createForm(new NewCompanyType(), $company);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($company);
            $em->flush();

            $this->addFlash('success', 'L\'entreprise '. $company->getName() .' a été correctement mise à jour');
            return $this->redirectToRoute('admin_show_all_company');
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * Delete a given company /!\ This is definitive, no turning back possible
     *
     * This also delete cascade all elements attached to the company:
     * - All Company Roles (Access Role company)
     * - All Projects Categories
     * And Remove company from projects companies list
     *
     * @Route("/{id}/delete", name="admin_delete_company")
     * @Method("DELETE")
     * @Template()
     */
    public function deleteCompanyAction($id)
    {
        // Searching requested company
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('GPCoreBundle:Company')->find($id);

        // Checking if company exists
        if (!$company) {
            $this->addFlash('error', 'Entreprise introuvable');
            return $this->redirectToRoute('admin_show_all_company');
        }

        // Remove Company
        $em = $this->getDoctrine()->getManager();
        $em->remove($company);
        $em->flush();

        $this->addFlash('success', 'L\'entreprise '. $company->getName() .' a été correctement supprimée');
        return $this->redirectToRoute('admin_show_all_company');
    }

    /**
     * Add new user to given company
     *
     * @Route("/{id}/add-user", name="admin_add_user_to_company")
     * @Method("GET|POST")
     * @Template("GPUserBundle:Admin/Company:addUserToCompany.html.twig")
     */
    public function AddUserToCompanyAction(Request $request, $id)
    {
        // Searching requested company
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('GPCoreBundle:Company')->find($id);

        // Checking if company exists
        if (!$company) {
            $this->addFlash('error', 'Entreprise introuvable');
            return $this->redirectToRoute('admin_show_all_company');
        }

        $companyUsers = $company->getUsers();

        $form = $this->createForm(new addUserToCompanyType($company));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $selectedUser = $form->get('users')->getData();
            $username = $selectedUser->getFirstName() . ' ' . $selectedUser->getLastName();

            foreach ($companyUsers as $user) {
                if ($user->getId() == $selectedUser->getId()) {
                    $this->addFlash('error', 'L\'utilisateur ' . $username . ' est déja membre de l\'entreprise ' . $company->getName());
                    return $this->redirectToRoute('admin_show_company', array('id' => $company->getId()));
                }
            }

            $selectedUser->addCompany($company);
            $em->persist($selectedUser);
            $em->flush();

            $this->addFlash('success', 'L\'utilisateur ' . $username . ' a été correctement ajouté à l\'entreprise ' . $company->getName());
            return $this->redirectToRoute('admin_show_company', array('id' => $company->getId()));
        }

        return array(
            'company' => $company,
            'form' => $form->createView()
        );
    }
}
