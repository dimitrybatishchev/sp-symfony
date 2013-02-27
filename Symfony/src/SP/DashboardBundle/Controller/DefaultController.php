<?php

namespace SP\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

use SP\UserBundle\Document\User;
use SP\PurchaseBundle\Document\Purchase;
use SP\PurchaseBundle\Document\Offer;
use SP\PurchaseBundle\Document\PurchaseStatus;
use SP\PurchaseBundle\Document\Order;
use SP\PurchaseBundle\Document\OrderItem;

/**
 * City controller.
 *
 * @Route("/dashboard")
 */
class DefaultController extends Controller
{
    /**
     * View control panel to user
     *
     * @Route("/", name="dashboard")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($name)
    {
        return $this->render('DashboardBundle:Default:index.html.twig', array('name' => $name));
    }
    
    /**
     * View control panel to user
     *
     * @Route("/orders", name="orders_list")
     * @Method("GET")
     * @Template("DashboardBundle:Default:user_orders.html.twig")
     */
    public function orderListAction()
    {
        $em = $this->get('doctrine_mongodb')->getManager();

        // устанавливаем текущего пользователя
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        $orders = $em->createQueryBuilder('PurchaseBundle:Order')
            ->field('user.$id')->equals(new \MongoId($user->getId()))
            ->getQuery()->execute();
        
        return array('orders' => $orders);
    }
    
    /**
     * View control panel to user
     *
     * @Route("/sp-list", name="dashboard_purchases_list")
     * @Method("GET")
     * @Template()
     */
    public function spListAction()
    {
        $em = $this->get('doctrine_mongodb')->getManager();

        // устанавливаем текущего пользователя
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        // жопа жопа жопа жопа
        // денормализовать как время будет
        $entities = $em->createQueryBuilder('PurchaseBundle:Purchase')
            ->field('owner.$id')->equals(new \MongoId($user->getId()))
            ->getQuery()->execute();  

        return $this->render('DashboardBundle:Default:sp_list.html.twig', array('entities' => $entities));
    }
    
    /**
     * Archive of SP
     *
     * @Route("/archive", name="archive")
     * @Method("GET")
     * @Template()
     */
    public function archiveAction()
    {
        $em = $this->get('doctrine_mongodb')->getManager();

        // устанавливаем текущего пользователя
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        $statusDecline = $em->getRepository('PurchaseBundle:PurchaseStatus')->findOneByPublicId(PurchaseStatus::STATUS_DECLINE);
        $statusStop = $em->getRepository('PurchaseBundle:PurchaseStatus')->findOneByPublicId(PurchaseStatus::STATUS_STOP);
                
        $qb = $em->createQueryBuilder('PurchaseBundle:Purchase')
                ->field('owner.$id')->equals(new \MongoId($user->getId()));
        $qb->addOr($qb->expr()->field('status.$id')->equals($statusDecline->getId()));
        $qb->addOr($qb->expr()->field('status.$id')->equals($statusStop->getId()));
        $entities = $qb->getQuery()->execute(); 

        return $this->render('DashboardBundle:Default:archive.html.twig', array('entities' => $entities));
    }
    
    
    
}
