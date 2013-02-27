<?php

namespace SP\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

use SP\UserBundle\Form\UserProfileType; 

use SP\UserBundle\Document\User;
use SP\UserBundle\Document\FriendshipRequest;

/**
 * User controller.
 *
 * @Route("/")
 */
class ProfileController extends Controller
{
    /**
     * Lists all Category entities.
     *
     * @Route("/profile/friendship-requests-count", name="friendship_requests_count")
     * @Method("GET")
     * @Template()
     */
    public function friendshipRequestsCountAction()
    {
        $em = $this->get('doctrine_mongodb')->getManager();
        
        // устанавливаем текущего пользователя
        $user = $this->container->get('security.context')->getToken()->getUser();
        $friendshipRequests = $em->createQueryBuilder('UserBundle:FriendshipRequest')
            ->field('receiver.$id')->equals(new \MongoId($user->getId()))
            ->getQuery()->execute();  
        
        return $this->render('UserBundle:Profile:friendship_requests_count.html.twig', array('friendship_requests' => $friendshipRequests));
    }
    
    /**
     * Lists all Category entities.
     *
     * @Route("/profile/friendship-confirm/{id}", name="friendship_confirm")
     * @Method("GET")
     * @Template()
     */
    public function friendshipConfirmAction($id)
    {
        $em = $this->get('doctrine_mongodb')->getManager();
        $friendshipRequest = $em->getRepository('UserBundle:FriendshipRequest')->find($id);
        
        $receiver = $this->container->get('security.context')->getToken()->getUser();
        $sender = $friendshipRequest->getSender();
        
        $receiver->setFriends($sender);
        $sender->setFriends($receiver);
        
        $friendshipRequest->setIsConfirmed(TRUE);
        
        $em->flush();
        
        return $this->redirect($this->generateUrl('friendship_requests', array()));
    }
    
    /**
     * Lists all Category entities.
     *
     * @Route("/profile/edit/", name="profile_edit")
     * @Method("GET")
     * @Template()
     */
    public function profileEditAction()
    {
        // устанавливаем текущего пользователя
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        $form   = $this->createForm(new UserProfileType(), $user);
        
        return $this->render('UserBundle:Profile:profile_edit.html.twig', array('user' => $user, 'form'   => $form->createView()));
    }
    
        /**
     * Edits an existing Product entity.
     *
     * @Route("/profile/update", name="profile_update")
     * @Method("POST")
     * @Template("UserBundle:Profile:profile_edit.html.twig")
     */
    public function profileUpdateAction(Request $request)
    {
        $em = $this->get('doctrine_mongodb')->getManager();

        // устанавливаем текущего пользователя
        $user = $this->container->get('security.context')->getToken()->getUser();

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createForm(new UserProfileType(), $user);
        $editForm->bind($request);
            
        if ($editForm->isValid()) {
            
            // заливаем файл на сервер
            $user->upload();
            
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('profile_edit', array()));
        }

        return array(
            'user'      => $user,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Lists all Category entities.
     *
     * @Route("/profile/friendship-requests", name="friendship_requests")
     * @Method("GET")
     * @Template()
     */
    public function friedshipRequestsAction()
    {
        $em = $this->get('doctrine_mongodb')->getManager();

        // устанавливаем текущего пользователя
        $user = $this->container->get('security.context')->getToken()->getUser();
        $friendshipRequests = $em->createQueryBuilder('UserBundle:FriendshipRequest')
            ->field('receiver.$id')->equals(new \MongoId($user->getId()))
            ->field('isConfirmed')->exists(FALSE)
            ->getQuery()->execute();  
        
        
        return $this->render('UserBundle:Profile:friendship_requests.html.twig', array('friendship_requests' => $friendshipRequests));
    }
    
    /**
     * Lists all Category entities.
     *
     * @Route("/profile/{username}/friends", name="friends")
     * @Method("GET")
     * @Template()
     */
    public function friendListAction($username)
    {
        $em = $this->get('doctrine_mongodb')->getManager();

        // устанавливаем текущего пользователя
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        return $this->render('UserBundle:Profile:friends.html.twig', array('user' => $user));
    }
    
}