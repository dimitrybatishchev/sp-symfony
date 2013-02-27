<?php

namespace SP\HelperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use SP\HelperBundle\Document\FaqItem;

/**
 * City controller.
 *
 * @Route("/")
 */
class DefaultController extends Controller
{  
    
    public function showMainPageAction()
    {
        return $this->render('HelperBundle:Default:main_page.html.twig');
    }
    
    /**
     * Lists all Category entities.
     *
     * @Route("/faq", name="faq")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->get('doctrine_mongodb')->getManager();

        $entities = $em->getRepository('HelperBundle:FaqItem')->findAll();

        return $this->render('HelperBundle:Default:faq.html.twig', array('faq' => $entities));
    }
}
