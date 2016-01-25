<?php

namespace GP\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class ProjectController
 * @package GP\ProjectBundle\Controller
 *
 * @Route("/secure/project")
 */
class ProjectController extends Controller
{
    /**
     * @Route("/", name="project_index")
     *
     * @Template()
     * @Method("GET")
     */
    public function indexAction()
    {
        return array();
    }
}
