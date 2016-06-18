<?php

namespace GP\UserBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use GP\CoreBundle\Entity\AccessRole;
use GP\UserBundle\Form\Type\Admin\AddAccessRoleType;

/**
 * Class Admin Role Controller
 *
 * @package GP\UserBundle\Controller
 *
 * @Route("/secure/admin/role")
 */
class AdminRoleController extends Controller
{
    /**
     * Returns the list of Role registered in the application
     *
     * @Route("/", name="admin_show_all_access_roles")
     * @Method("GET")
     * @Template("GPUserBundle:Admin/AccessRole:showAccessRoles.html.twig")
     */
    public function showAccessRolesAction(Request $request)
    {
        // Getting all Roles
        $em = $this->getDoctrine()->getManager();
        $unformatedAccessRoles = $em->getRepository('GPCoreBundle:AccessRole')->findAll();
        $accessRoles = $this->formatAccessRoles($unformatedAccessRoles );

        return array('accessRoles' => $accessRoles);
    }

    /**
     * Sort AccessRoles Collection
     * Sort by Company & Project AccessRoles
     *
     * @param $unformatedAccessRoles
     * @return array
     */
    private function formatAccessRoles($unformatedAccessRoles)
    {
        $accessRoles = array('company' => array(), 'project' => array());
        foreach ($unformatedAccessRoles as $accessRole) {
            if ($accessRole->getType() == AccessRole::TYPE_COMPANY) {
                array_push($accessRoles['company'], $accessRole);
            } elseif ($accessRole->getType() == AccessRole::TYPE_PROJECT) {
                array_push($accessRoles['project'], $accessRole);
            }
        }

        return $accessRoles;
    }

    /**
     * Create new access role for given company
     *
     * @Route("/company/{id}", name="admin_create_company_access_role")
     * @Method("GET|POST")
     * @Template("GPUserBundle:Admin/AccessRole:createCompanyAccessRole.html.twig")
     */
    public function createCompanyAccessRoleAction(Request $request, $id)
    {
        // Searching requested company
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('GPCoreBundle:Company')->find($id);

        // Checking if company exists
        if (!$company) {
            $this->addFlash('error', 'Entreprise introuvable');
            return $this->redirectToRoute('admin_show_all_company');
        }

        $accessRole = new AccessRole();
        $accessRole->setType(AccessRole::TYPE_COMPANY);
        $accessRole->setCompany($company);
        $form = $this->createForm(new AddAccessRoleType(), $accessRole);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($accessRole);
            $em->flush();

            $this->addFlash('success', 'suce ma bite');
            return $this->redirectToRoute('admin_show_company', array('id' => $id));
        }

        return array(
            'form' => $form->createView(),
            'company' => $company
        );
    }

    /**
     * Create new access role for given project
     *
     * @Route("/project/{id}", name="admin_create_project_access_role")
     * @Method("GET|POST")
     * @Template("GPUserBundle:Admin/AccessRole:createProjectAccessRole.html.twig")
     */
    public function createProjectAccessRoleAction(Request $request, $id)
    {
        // Searching requested project
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository('GPCoreBundle:Project')->find($id);

        // Checking if project exists
        if (!$project) {
            $this->addFlash('error', 'Projet introuvable');
            return $this->redirectToRoute('admin_show_all_project');
        }

        $accessRole = new AccessRole();
        $accessRole->setType(AccessRole::TYPE_PROJECT);
        $accessRole->setProject($project);
        $form = $this->createForm(new AddAccessRoleType(), $accessRole);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($accessRole);
            $em->flush();

            $this->addFlash('success', 'suce ma bite');
            return $this->redirectToRoute('admin_show_project', array('id' => $id));
        }

        return array(
            'form' => $form->createView(),
            'project' => $project
        );
    }

    /**
     * Display full data of a given given Role
     *
     * @Route("/{id}", name="admin_show_access_role")
     * @Method("GET")
     * @Template("GPUserBundle:Admin/AccessRole:showAccessRole.html.twig")
     */
    public function showAccessRoleAction(Request $request, $id)
    {
        // Getting requested Access Roles
        $em = $this->getDoctrine()->getManager();
        $accessRole = $em->getRepository('GPCoreBundle:AccessRole')->find($id);

        if (!$accessRole) {
            $this->addFlash('error', 'Le rôle est introuvable');
            return $this->redirectToRoute('admin_show_all_access_roles');
        }

        return array('accessRole' => $accessRole);
    }
}
