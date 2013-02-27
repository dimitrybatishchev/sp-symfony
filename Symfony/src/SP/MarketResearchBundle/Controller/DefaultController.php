<?php
namespace SP\MarketResearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use SP\MarketResearchBundle\Document\MarketResearch;
use SP\PurchaseBundle\Document\Comment;

use SP\MarketResearchBundle\Form\MarketResearchType;
use SP\PurchaseBundle\Form\CommentType;

/**
 * City controller.
 *
 * @Route("/mr")
 */
class DefaultController extends Controller
{   
    /**
     * Lists all Category entities.
     *
     * @Route("/", name="market_research_list")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->get('doctrine_mongodb')->getManager();

        $entities = $em->getRepository('MarketResearchBundle:MarketResearch')->findAll();

        return $this->render('MarketResearchBundle:Default:index.html.twig', array('entities' => $entities));
    }
    
    /**
     * @Route("/create", name="market_research_create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $marketResearch = new MarketResearch();
        $form = $this->createForm(new MarketResearchType(), $marketResearch);
        
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $em = $this->get('doctrine_mongodb')->getManager();
                $owner = $this->container->get('security.context')->getToken()->getUser();
                
                $marketResearch->upload();
                $marketResearch->setOwner($owner);
                $marketResearch->setCreated(new \DateTime());
                
                $em->persist($marketResearch);
                $em->flush();
                return $this->redirect($this->generateUrl('market_research_detail', array('id' => $marketResearch->getId())));
            }
        }

        return array(
            'marketResearch' => $marketResearch,
            'form'   => $form->createView(),
        );
    }
    
    /**
     * Finds and displays a SP entity.
     *
     * @Route("/{id}", name="market_research_detail")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {    
        $em = $this->get('doctrine_mongodb')->getManager();
        $mr = $em->getRepository('MarketResearchBundle:MarketResearch')->find($id);
        
        $comment = new Comment();
        $commentForm = $this->createForm(new CommentType(), $comment);
        
        $user = $this->container->get('security.context')->getToken()->getUser();

        if (!$mr) {
            throw $this->createNotFoundException('Unable to find Market Research entity.');
        }
        
        $voted = $mr->getVoted();
        $userAlreadyVote = FALSE;
        foreach ($voted as $votedUser){
            if ($votedUser == $user){
                $userAlreadyVote = TRUE;
                break;
            }
        }
        if (!$userAlreadyVote){
            $output["vote_form"] = $this->createVoteForm($id)->createView();
        }
        
        if ($user == $mr->getOwner()){
            $output["delete_form"] = $this->createDeleteForm($id)->createView();
        }
        
        $output["mr"] = $mr;
        $output["comment_form"] = $commentForm->createView();
        
        return $this->render(
            'MarketResearchBundle:Default:detail.html.twig', $output
        );  
    }
    
   /**
     * Deletes a Product entity.
     *
     * @Route("/{id}", name="market_research_vote")
     * @Method("POST")
     */
    public function voteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine_mongodb')->getManager();
            $marketResearch = $em->getRepository('MarketResearchBundle:MarketResearch')->find($id);

            if (!$marketResearch) {
                throw $this->createNotFoundException('Unable to find City entity.');
            }
            $user = $this->container->get('security.context')->getToken()->getUser();
            
            $marketResearch->setVoted($user);
            
            $em->flush();
        }

        return $this->redirect($this->generateUrl('market_research_detail', array('id' => $marketResearch->getId())));
    }
    
    /**
     * Deletes a Product entity.
     *
     * @Route("/{id}", name="market_research_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine_mongodb')->getManager();
            $entity = $em->getRepository('MarketResearchBundle:MarketResearch')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Market Research entity.');
            }
            
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('market_research_list'));
    }
    
    /**
     * Deletes a Product entity.
     *
     * @Route("/{id}/comment/create", name="market_research_comment_create")
     * @Method("POST")
     */
    public function addCommentToMarketResearchAction(Request $request, $id)
    {   
        $comment = new Comment();
      
        $form = $this->createForm(new CommentType(), $comment);
        $form->bind($request);
        
        if ($form->isValid()) {      
            $em = $this->get('doctrine_mongodb')->getManager();
            $marketResearch = $em->getRepository('MarketResearchBundle:MarketResearch')->find($id);

            $comment->setCreated(new \DateTime());
            
            // устанавливаем текущего пользователя
            $user = $this->container->get('security.context')->getToken()->getUser();
            
            $comment->setWriter($user);
            $em->persist($comment);     
            
            $marketResearch->setComments($comment);
            $em->flush();

            return $this->redirect($this->generateUrl('market_research_detail', array('id' => $marketResearch->getId())));
        }
        
        return array(
            'mr' => $marketResearch,
            'form'   => $form->createView(),
        );
        
    }
    
    /**
     * Creates a form to delete a Product entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createVoteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * Creates a form to delete a Product entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
