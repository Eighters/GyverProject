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
}
