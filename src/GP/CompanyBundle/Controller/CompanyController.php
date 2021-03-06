<?php

namespace GP\CompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class ProjectController
 * @package GP\ProjectBundle\Controller
 *
 * @Route("/secure/company")
 */
class CompanyController extends Controller
{
    /**
     * Display companies of current user
     *
     * @Route("/", name="show_all_companies")
     *
     * @Method("GET")
     * @Template()
     */
    public function showCompaniesAction()
    {
        // Getting all User Companies
        $em = $this->getDoctrine()->getManager();
        $companies = $em->getRepository('GPCoreBundle:Company')->findUserCompanies($this->getUser());

        return array('companies' => $companies);
    }

    /**
     * Display data of the given company
     *
     * @Route("/{id}", name="show_company")
     * @Method("GET")
     * @Template()
     */
    public function showCompanyAction($id)
    {
        // Searching requested Company
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('GPCoreBundle:Company')->find($id);

        // Checking if Company exists
        if (!$company) {
            $this->addFlash('error', 'Entreprise introuvable');
            return $this->redirectToRoute('show_all_companies');
        }

        // Check if user have right to view company data
        if (!$company->checkUserAccess($this->getUser()) && !$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') ) {
            throw new AccessDeniedException();
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
}
