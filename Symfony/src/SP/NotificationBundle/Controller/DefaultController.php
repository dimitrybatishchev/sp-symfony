<?php

namespace SP\NotificationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Notification controller.
 *
 * @Route("/notification")
 */
class DefaultController extends Controller
{   
    /**
     * Lists all Category entities.
     *
     * @Route("/", name="notifications")
     * @Method("GET")
     */
    public function notificationListAction()
    {
        $em = $this->get('doctrine_mongodb')->getManager();
        
        // устанавливаем текущего пользователя
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        $notifications = $em->createQueryBuilder('NotificationBundle:Notification')
            ->field('owner.$id')->equals(new \MongoId($user->getId()))
            ->field('readed')->equals(False)
            ->getQuery()->execute();  
        
        return $this->render('NotificationBundle:Default:index.html.twig', array('notifications' => $notifications));
    }
    
    /**
     * Lists all Category entities.
     *
     * @Route("/notifications/unread/count", name="unread_notifications_count")
     * @Method("GET")
     */
    public function unreadNotificationsCountAction()
    {
        $em = $this->get('doctrine_mongodb')->getManager();
        
        // устанавливаем текущего пользователя
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        $notifications = $em->createQueryBuilder('NotificationBundle:Notification')
            ->field('owner.$id')->equals(new \MongoId($user->getId()))
            ->field('readed')->equals(False)
            ->getQuery()->execute();  
        
        return $this->render('NotificationBundle:Default:unread_notifications_count.html.twig', array('notifications' => $notifications));
    }
}
