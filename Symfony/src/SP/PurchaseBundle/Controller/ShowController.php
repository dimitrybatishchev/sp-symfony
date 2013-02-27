<?php

namespace SP\PurchaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

use SP\PurchaseBundle\Form\PurchaseType;
use SP\PurchaseBundle\Form\PurchaseStopType;
use SP\PurchaseBundle\Form\OfferType;
use SP\PurchaseBundle\Form\CommentType;

use SP\PurchaseBundle\Document\Purchase;
use SP\PurchaseBundle\Document\Offer;
use SP\PurchaseBundle\Document\PurchaseStatus;
use SP\PurchaseBundle\Document\Comment;

/**
 * City controller.
 *
 * @Route("/sp")
 */
class ShowController extends Controller{    
    
    /**
     * Lists all Category entities.
     *
     * @Route("/", name="purchases_list")
     * @Method("GET")
     * @Template()
     */
    public function allPurchasesAction()
    {
        $em = $this->get('doctrine_mongodb')->getManager();

        $purchases = $em->getRepository('PurchaseBundle:Purchase')->findAll();

        return $this->render('PurchaseBundle:Show:purchases.html.twig', array('purchases' => $purchases));
    }
    
    /**
     * Отображает все закупки в определенной категории
     *
     * @Route("/category/{id}", name="purchase_list_by_category")
     * @Method("GET")
     * @Template()
     */
    public function showPurchasesByCategoryAction($id)
    {
        $em = $this->get('doctrine_mongodb')->getManager();

        $entities = $em->getRepository('SPBundle:SP')->findAll();

        return $this->render('SPBundle:Default:sp_list.html.twig', array('entities' => $entities));
    }
    
    /**
     * Отображает все закупки одного организатора
     *
     * @Route("/user/{username}", name="purchase_list_by_user")
     * @Method("GET")
     * @Template()
     */
    public function showPurchasesByUserAction($username)
    {
        $em = $this->get('doctrine_mongodb')->getManager();
        $user = $em->getRepository('UserBundle:User')->findOneByUsername($username);

        $purchases = $em->createQueryBuilder('SPBundle:SP')
            ->field('owner.$id')->equals(new \MongoId($user->getId()))
            ->getQuery()->execute();

        return $this->render('SPBundle:Default:sp_list.html.twig', array('entities' => $purchases));
    }
    
    /**
     * View control panel to user
     *
     * @Route("/orders", name="purchase_archive")
     * @Method("GET")
     * @Template("SPBundle:Show:purchase_archive.html.twig")
     */
    public function archiveAction()
    {
        $em = $this->get('doctrine_mongodb')->getManager();

        // устанавливаем текущего пользователя
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        $orders = $em->createQueryBuilder('SPBundle:Order')
            ->field('user.$id')->equals(new \MongoId($user->getId()))
            ->getQuery()->execute();
        
        return array('orders' => $orders);
    }
    
    
}