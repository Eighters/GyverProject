<?php

namespace GP\UserBundle\Controller\Admin;

use GP\CoreBundle\Entity\AccessRole;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

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
