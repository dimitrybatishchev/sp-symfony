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
class UserController extends Controller
{
    /**
     * Lists all Category entities.
     *
     * @Route("/user/{username}/", name="user")
     * @Method("GET")
     * @Template()
     */
    public function viewUserProfileAction(Request $request, $username)
    {
        // устанавливаем текущего пользователя
        $em = $this->get('doctrine_mongodb')->getManager();
        $user = $em->getRepository('UserBundle:User')->findOneByUsername($username);
        $addToFriendsForm = $this->createAddToFriendsForm($username);
        
        return $this->render('UserBundle:User:profile.html.twig', 
                array(
                    'user' => $user,
                    'add_to_friends_form' => $addToFriendsForm->createView(),
                    ));
    }
    
    /**
     * Lists all Category entities.
     *
     * @Route("/user/{username}/add-to-friends", name="user_add_to_friends")
     * @Method("POST")
     * @Template()
     */
    public function addToFriendsAction(Request $request, $username)
    {
        $em = $this->get('doctrine_mongodb')->getManager();
        $receiver = $em->getRepository('UserBundle:User')->findOneByUsername($username);
        
        // устанавливаем текущего пользователя
        $sender = $this->container->get('security.context')->getToken()->getUser();
        
        $friendshipRequest = new FriendshipRequest();
        $friendshipRequest->setSender($sender);
        $friendshipRequest->setReceiver($receiver);
        $em->persist($friendshipRequest);
        $em->flush();
        
        return $this->redirect($this->generateUrl('user', array('username' => $receiver->getUsername())));
    }
    
    /**
     * Lists all Category entities.
     *
     * @Route("/user/add-to-blacklist", name="user_add_to_blacklist")
     * @Method("GET")
     * @Template()
     */
    public function addToBlackListAction(Request $request)
    {
        // устанавливаем текущего пользователя
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        return $this->render('UserBundle:User:profile.html.twig', array('user' => $user));
    }
    
    /**
     * Lists all Category entities.
     *
     * @Route("/user/gift", name="user_gift")
     * @Method("GET")
     * @Template()
     */
    public function giftToUserAction(Request $request)
    {
        // устанавливаем текущего пользователя
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        return $this->render('UserBundle:User:profile.html.twig', array('user' => $user));
    }
    
    private function createAddToFriendsForm($username)
    {
        return $this->createFormBuilder(array('username' => $username))
            ->add('username', 'hidden')
            ->getForm()
        ;
    }
}