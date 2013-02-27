<?php

namespace SP\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * City controller.
 *
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * Lists all Product entities.
     *
     * @Route("/", name="admin_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        return $this->render('AdminBundle:Default:index.html.twig');
    }
    
    /**
     * Lists all Editable entities.
     *
     * @Route("/entity", name="admin_entities")
     * @Method("GET")
     * @Template()
     */
    public function entitiesAction()
    {
        return $this->render('AdminBundle:Default:entities.html.twig');
    }
}
