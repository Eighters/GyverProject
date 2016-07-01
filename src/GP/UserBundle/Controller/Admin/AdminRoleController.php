<?php

namespace GP\UserBundle\Controller\Admin;

use GP\CoreBundle\Entity\User;
use GP\UserBundle\Form\Type\Admin\AddUserToAccessRoleType;
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
     * Returns the list of Access Role registered in the application
     *
     * @Route("/", name="admin_show_all_access_roles")
     * @Method("GET")
     * @Template("GPUserBundle:Admin/AccessRole:showAccessRoles.html.twig")
     */
    public function showAccessRolesAction()
    {
        // Getting all Access Roles
        $em = $this->getDoctrine()->getManager();
        $unformatedAccessRoles = $em->getRepository('GPCoreBundle:AccessRole')->findAll();
        $accessRoles = $this->formatAccessRoles($unformatedAccessRoles );

        return array('accessRoles' => $accessRoles);
    }

    /**
     * Display full data of a given Access Role
     *
     * @Route("/{id}", name="admin_show_access_role")
     * @Method("GET")
     * @Template("GPUserBundle:Admin/AccessRole:showAccessRole.html.twig")
     */
    public function showAccessRoleAction($id)
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

    /**
     * Create new access role for given company
     *
     * @Route("/{id}/company", name="admin_create_company_access_role")
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

            $logger = $this->get('monolog.logger.user_access');
            $logger->alert('[COMPANY_ROLE_ADD] ' . $this->getUser()->getEmail() .' have added new role ' . $accessRole->getName() . ' to company '. $company->getName());

            $this->addFlash('success', 'Le rôle: '. $accessRole->getName() . ' a été ajouté avec succès à l\'entreprise '.$company->getName());
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
     * @Route("/{id}/project", name="admin_create_project_access_role")
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

            $logger = $this->get('monolog.logger.user_access');
            $logger->alert('[PROJECT_ROLE_ADD] ' . $this->getUser()->getEmail() .' have added new role ' . $accessRole->getName() . ' to project '. $project->getName());

            $this->addFlash('success', 'Le rôle: '. $accessRole->getName().' a été ajouté avec succès au projet '.$project->getName());
            return $this->redirectToRoute('admin_show_project', array('id' => $id));
        }

        return array(
            'form' => $form->createView(),
            'project' => $project
        );
    }

    /**
     * Delete given Access Role
     *
     * @Route("/{id}", name="admin_delete_access_role")
     * @Method("DELETE")
     */
    public function deleteAccessRoleAction($id)
    {
        // Getting requested Access Roles
        $em = $this->getDoctrine()->getManager();
        $accessRole = $em->getRepository('GPCoreBundle:AccessRole')->find($id);

        if (!$accessRole) {
            $this->addFlash('error', 'Le rôle est introuvable');
            return $this->redirectToRoute('admin_show_all_access_roles');
        }

        $em->remove($accessRole);
        $em->flush();

        $logger = $this->get('monolog.logger.user_access');
        $logger->alert('[ACCESS_ROLE_DELETE] ' . $this->getUser()->getEmail() .' have deleted role ' . $accessRole->getName());

        $this->addFlash('success', 'Le rôle ' . $accessRole->getName() . ' a été supprimé avec succès');
        return $this->redirectToRoute('admin_show_all_access_roles');
    }

    /**
     * Add user to role list
     *
     * @Route("/{id}/add-user", name="admin_add_user_access_role")
     * @Method("GET|POST")
     * @Template("GPUserBundle:Admin/AccessRole:addUserToAccessRole.html.twig")
     */
    public function addUserToAccessRoleAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $accessRole = $em->getRepository('GPCoreBundle:AccessRole')->find($id);
        if (!$accessRole) {
            $this->addFlash('error', 'Le rôle est introuvable');
            return $this->redirectToRoute('admin_show_access_role', array('id' => $id));
        }

        $form = $this->createForm(new AddUserToAccessRoleType(), $accessRole);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $user = $form->get('users')->getData();
            $user->addAccessRole($accessRole);

            $em->persist($user);
            $em->flush();

            $username = $user->getFirstName() . " " . $user->getLastName();
            $this->addFlash('success', "Le rôle ". $accessRole->getName(). " a bien été affecté à l'utilisateur " . $username);
            return $this->redirectToRoute('admin_show_access_role', array('id' => $id));
        }

        return array(
            'form' => $form->createView(),
            'accessRole' => $accessRole
        );
    }

    /**
     * Remove access role for given user
     *
     * @Route("/{id}/user/{user_id}", name="admin_remove_user_access_role")
     * @Method("DELETE")
     */
    public function removeAccessRoleForUserAction($id, $user_id)
    {
        $em = $this->getDoctrine()->getManager();

        $accessRole = $em->getRepository('GPCoreBundle:AccessRole')->find($id);
        if (!$accessRole) {
            $this->addFlash('error', 'Le rôle est introuvable');
            return $this->redirectToRoute('admin_show_access_role', array('id' => $id));
        }

        $user = $em->getRepository('GPCoreBundle:User')->find($user_id);
        if (!$user) {
            $this->addFlash('error', "L'utilisateur est introuvable");
            return $this->redirectToRoute('admin_show_access_role', array('id' => $id));
        }

        $accessRoleUsers = $accessRole->getUsers();
        $permission = $this->checkUserHaveAccessRole($user, $accessRoleUsers);
        if (!$permission) {
            $this->addFlash('error', "Impossible, l'utilisateur ne posséde pas le rôle");
            return $this->redirectToRoute('admin_show_access_role', array('id' => $id));
        }

        $user->removeAccessRole($accessRole);
        $em->persist($user);
        $em->flush();

        $username = $user->getFirstName() . ' ' . $user->getLastName();
        $logger = $this->get('monolog.logger.user_access');
        $logger->alert('[ACCESS_ROLE_USER_REMOVE] ' . $this->getUser()->getEmail() .' have removed role ' . $accessRole->getName() . ' for user ' . $username);

        $this->addFlash('success', "Le rôle ". $accessRole->getName(). " a été retiré à l'utilisateur " . $user->getFirstName() . " " . $user->getLastName());
        return $this->redirectToRoute('admin_show_access_role', array('id' => $id));
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
     * Check if the given user has granted the role
     *
     * @param User $currentUser
     * @param $accessRoleUsers
     *
     * @return bool
     */
    private function checkUserHaveAccessRole(User $currentUser, $accessRoleUsers)
    {
        $permission = false;
        foreach ($accessRoleUsers as $user) {
            if ($user == $currentUser) {
                return $permission = true;
            }
        }
        return $permission;
    }
}
