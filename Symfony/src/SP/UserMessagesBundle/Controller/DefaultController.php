<?php

namespace SP\UserMessagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

use SP\UserMessagesBundle\Form\MessageType; 

use SP\UserMessagesBundle\Document\Message;
use SP\UserMessagesBundle\Document\Dialog;

/**
 * User messages controller.
 *
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     *
     *
     * @Route("/", name="messages_main")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->get('doctrine_mongodb')->getManager();
        
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        $dialogs = $em->createQueryBuilder('UserMessagesBundle:Dialog')
        ->field('sender.$id')->equals(new \MongoId($user->getId()))
        ->getQuery()->execute(); 
        /*
        $qb = $em->createQueryBuilder('UserMessagesBundle:Dialog');
        $qb->addOr($qb->expr()->field('receiver.$id')->equals(new \MongoId($user->getId())));
        $qb->addOr($qb->expr()->field('sender.$id')->equals(new \MongoId($user->getId())));
        $dialogs = $qb->getQuery()->execute(); 
         * 
         */
        return $this->render('UserMessagesBundle:Default:main.html.twig', array('dialogs' => $dialogs));
    }
    
    /**
     * Lists all Category entities.
     *
     * @Route("/messages/unread/count", name="unread_messages_count")
     * @Method("GET")
     * @Template()
     */
    public function unreadMessagesCountAction()
    {
        $em = $this->get('doctrine_mongodb')->getManager();
        
        // устанавливаем текущего пользователя
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        $messages = $em->createQueryBuilder('UserMessagesBundle:Message')
            ->field('receiver.$id')->equals(new \MongoId($user->getId()))
            ->field('isRead')->equals(False)
            ->getQuery()->execute();  
        
        return $this->render('UserMessagesBundle:Default:unread_messages_count.html.twig', array('messages' => $messages));
    }
    
    /**
     *
     *
     * @Route("/dialog/{username}/", name="messages_dialog")
     * @Method("GET")
     * @Template()
     */
    public function dialogAction(Request $request, $username)
    {
        $em = $this->get('doctrine_mongodb')->getManager();
        
        $user = $this->container->get('security.context')->getToken()->getUser();
        $companion = $em->getRepository('UserBundle:User')->findOneByUsername($username);
        
        $qb = $em->createQueryBuilder('UserMessagesBundle:Message');
        $qb->addOr($qb->expr()
                ->field('sender.$id')->equals(new \MongoId($user->getId()))
                ->field('receiver.$id')->equals(new \MongoId($companion->getId())));
        $qb->addOr($qb->expr()
                ->field('receiver.$id')->equals(new \MongoId($user->getId()))
                ->field('sender.$id')->equals(new \MongoId($companion->getId())));
        $messages = $qb->getQuery()->execute(); 
        
        return $this->render('UserMessagesBundle:Default:dialog.html.twig', array('messages' => $messages));
    }
    
    /**
     *
     *
     * @Route("/new/", name="messages_new")
     * @Method("GET")
     * @Template()
     */
    public function newMessageAction()
    {
        $entity = new Message();
        $form   = $this->createForm(new MessageType());
        return $this->render('UserMessagesBundle:Default:new_message.html.twig', array('form'   => $form->createView()));
    }
    
    /**
     * Creates a new Product entity.
     *
     * @Route("/", name="messages_create")
     * @Method("POST")
     * @Template("UserMessagesBundle:Default:new_message.html.twig")
     */
    public function createMessageAction(Request $request)
    {   
        $message = new Message();
        $form = $this->createForm(new MessageType());
        $form->bind($request);  

        if ($form->isValid()) {
            $data = $form->getData();
            
            $em = $this->get('doctrine_mongodb')->getManager();
            $receiver = $em->getRepository('UserBundle:User')->findOneByUsername($data['receiver']);
            $sender = $this->container->get('security.context')->getToken()->getUser();
            $message->setSender($sender);
            $message->setReceiver($receiver);
            $message->setBody($data['body']);
            $message->setSentTime(new \DateTime());     
            $em->persist($message);
            
            $receiverDialog = $em->createQueryBuilder('UserMessagesBundle:Dialog')
            ->field('receiver.$id')->equals(new \MongoId($sender->getId()))
            ->field('sender.$id')->equals(new \MongoId($receiver->getId()))
            ->getQuery()->getSingleResult();  
            
            $senderDialog = $em->createQueryBuilder('UserMessagesBundle:Dialog')
            ->field('receiver.$id')->equals(new \MongoId($receiver->getId()))
            ->field('sender.$id')->equals(new \MongoId($sender->getId()))
            ->getQuery()->getSingleResult(); 
            
            if ($receiverDialog && $senderDialog){
                $receiverDialog->setSender($sender);
                $receiverDialog->setReceiver($receiver);
                $receiverDialog->setMessage($message);
                $senderDialog->setSender($receiver);
                $senderDialog->setReceiver($sender);
                $senderDialog->setMessage($message);
            } else {
                $receiverDialog = new Dialog();
                $receiverDialog->setSender($sender);
                $receiverDialog->setReceiver($receiver);
                $receiverDialog->setMessage($message);
                $senderDialog = new Dialog();
                $senderDialog->setSender($receiver);
                $senderDialog->setReceiver($sender);
                $senderDialog->setMessage($message);
                $em->persist($receiverDialog);
                $em->persist($senderDialog);
            }
            
            $em->flush();

            return $this->redirect($this->generateUrl('messages_main', array()));
        }

        return array(
            'message' => $message,
            'form'   => $form->createView(),
        );
    }
    
}