<?php

namespace SP\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * User controller.
 *
 * @Route("/catalog")
 */
class DefaultController extends Controller
{
    /**
     * Lists all Category entities.
     *
     * @Route("/", name="categories_list")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        return $this->render('CatalogBundle:Default:index.html.twig', array());
    }
    
    /**
     * Lists all Category entities.
     *
     * @Route("/categories/menu/", name="category_list_for_menu")
     * @Method("GET")
     * @Template("CatalogBundle:Default:for_menu.html.twig")
     */
    public function listForMenuAction()
    {
        $em = $this->get('doctrine_mongodb')->getManager();

        $categories = $em->getRepository('CatalogBundle:Category')->findAll();

        return array(
            'categories' => $categories,
        );
    }
    
}
