<?php

namespace GP\CompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class ProjectController
 * @package GP\ProjectBundle\Controller
 *
 * @Route("/secure/company")
 */
class CompanyController extends Controller
{
    /**
     * @Route("/", name="company_index")
     *
     * @Template()
     * @Method("GET")
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/{id}", name="company_show")
     * @Method("GET")
     * @Template()
     */
    public function showCompanyAction($id)
    {
        // Searching requested project
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('GPCoreBundle:Company')->find($id);

        // Checking if company exists
        if (!$company) {
            $this->addFlash('error', 'Compagnie introuvable');
            return $this->redirectToRoute('company_index');
        }

        return array('company' => $company);
    }
}
