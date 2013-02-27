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
class RenderController extends Controller
{   
    /**
     * Lists all Category entities.
     *
     * @Route("/render/{notificationId}", name="render_notification")
     * @Method("GET")
     */
    public function renderNotificationAction($notificationId)
    {  
        $em = $this->get('doctrine_mongodb')->getManager();
        $notification = $em->getRepository('NotificationBundle:Notification')->find($notificationId);
        $notificationTemplate = $notification->getTemplate();
        return $this->render($notificationTemplate, array('notification' => $notification));
    }

}
