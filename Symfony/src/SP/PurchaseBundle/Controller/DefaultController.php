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
use SP\PurchaseBundle\Form\OrderItemType;

use SP\PurchaseBundle\Document\Purchase;
use SP\PurchaseBundle\Document\Offer;
use SP\PurchaseBundle\Document\PurchaseStatus;
use SP\PurchaseBundle\Document\Comment;
use SP\PurchaseBundle\Document\Order;
use SP\PurchaseBundle\Document\OrderItem;

use SP\NotificationBundle\Document\PurchaseCreatedNotification;

/**
 * @Route("/sp")
 */
class DefaultController extends Controller
{   
    /**
     * Создаем новую закупку
     *
     * @Route("/new", name="purchase_create")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $purchase = new Purchase();
        $form   = $this->createForm(new PurchaseType(), $purchase);
        if ($request->isMethod('POST')) {
            $form->bind($request);
            
            if ($form->isValid()) {
                $em = $this->get('doctrine_mongodb')->getManager();

                // устанавливаем текущего пользователя
                $user = $this->container->get('security.context')->getToken()->getUser();
                if (!is_object($user) || !$user instanceof UserInterface) {
                    throw new AccessDeniedException(
                           'This user does not have access to this section.');
                }
                $purchase->setOwner($user);

                // получаем статус "Формирование"
                $status = $em->getRepository('PurchaseBundle:PurchaseStatus')->findOneByPublicId(PurchaseStatus::STATUS_FORMATION);
                $purchase->setStatus($status);

                // выставляем дату в закупке
                $purchase->setCreated(new \DateTime());

                $em->persist($purchase);
                
                // посылаем уведомление
                $this->get('notification')->sendPurchaseCreatedNotification($purchase);
                
                $em->flush();

                return $this->redirect($this->generateUrl('purchase_detail', array('id' => $purchase->getId())));
            }
        }
    
        return array(
            'purchase' => $purchase,
            'form'   => $form->createView(),
        );
    }
    
    
    /**
     * Finds and displays a SP entity.
     *
     * @Route("/{id}", name="purchase_detail")
     * @Method("GET")
     * @Template()
     */
    public function detailAction($id)
    {    
        $em = $this->get('doctrine_mongodb')->getManager();
        $purchase = $em->getRepository('PurchaseBundle:Purchase')->find($id);

        if (!$purchase) {
            throw $this->createNotFoundException('Unable to find Purchase entity.');
        }
        
        if ($purchase->getStatus()->getPublicId() == PurchaseStatus::STATUS_FORMATION){
            return $this->render(
                    'PurchaseBundle:Purchase:purchase_status_formation.html.twig',
                    array(
                        'purchase'      => $purchase,
                    )
            );
        } else {
            $comment = new Comment();
            $commentForm   = $this->createForm(new CommentType(), $comment);
            
            return $this->render(
                    'PurchaseBundle:Purchase:purchase_status_orders.html.twig',
                    array(
                        'purchase'      => $purchase,
                        'comment_form'   => $commentForm->createView(),
                    )
            );
        }
    }
    
    /**
     * Deletes a Product entity.
     *
     * @Route("/{id}/comment/create", name="purchase_comment_create")
     * @Method("POST")
     */
    public function addCommentToPurchaseAction(Request $request, $id)
    {   
        $comment = new Comment();
      
        $form = $this->createForm(new CommentType(), $comment);
        $form->bind($request);
        
        if ($form->isValid()) {      
            $em = $this->get('doctrine_mongodb')->getManager();
            $sp = $em->getRepository('SPBundle:SP')->find($id);

            // выставляем дату в закупке
            $comment->setCreated(new \DateTime());
            
            // устанавливаем текущего пользователя
            $user = $this->container->get('security.context')->getToken()->getUser();
            if (!is_object($user) || !$user instanceof UserInterface) {
                throw new AccessDeniedException(
                    'This user does not have access to this section.');
            }
            
            $comment->setWriter($user);

            $em->persist($comment);     
            
            $sp->setComments($comment);
            
            $em->flush();

            return $this->redirect($this->generateUrl('sp_show', array('id' => $sp->getId())));
        }
        
        return array(
            'sp' => $sp,
            'form'   => $form->createView(),
        );
        
    }
    
    /**
     * Deletes a Product entity.
     *
     * @Route("/{spId}/offers/{offerId}/comment/create", name="offer_comment_create")
     * @Method("POST")
     */
    public function addCommentToOfferAction(Request $request, $spId, $offerId)
    {   
        $comment = new Comment();
    
        $form = $this->createForm(new CommentType(), $comment);
        $form->bind($request);
        
        if ($form->isValid()) {      
            $em = $this->get('doctrine_mongodb')->getManager();
            $offer = $em->getRepository('SPBundle:SPItem')->find($offerId);
            
            // выставляем дату в закупке
            $comment->setCreated(new \DateTime());
            
            // устанавливаем текущего пользователя
            $user = $this->container->get('security.context')->getToken()->getUser();
            if (!is_object($user) || !$user instanceof UserInterface) {
                throw new AccessDeniedException(
                    'This user does not have access to this section.');
            }
            
            $comment->setWriter($user);

            $em->persist($comment);     
            
            $offer->setComments($comment);
            
            $em->flush();

            return $this->redirect($this->generateUrl('sp_offer_show', array('sp_id' => $offer->getSp()->getId(), 'offer_id' => $offer->getId())));
        }
        
        return array(
            'offer' => $offer,
            'form'   => $form->createView(),
        );
        
    }
    
    /**
     * Edit SP
     *
     * @Route("/{id}/edit", name="purchase_edit")
     * @Method("GET")
     * @Template("PurchaseBundle:Purchase:purchase_edit.html.twig")
     */
    public function editAction($id)
    {        
        $em = $this->get('doctrine_mongodb')->getManager();

        $purchase = $em->getRepository('PurchaseBundle:Purchase')->find($id);

        if (!$purchase) {
            throw $this->createNotFoundException('Unable to find Purchase entity.');
        }
        
        $deleteForm = $this->createDeleteForm($id);
        
        return array(
            'purchase'      => $purchase,
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
     * Deletes a Product entity.
     *
     * @Route("/{id}/edit/delete", name="sp_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine_mongodb')->getManager();
            $entity = $em->getRepository('SPBundle:SP')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SP entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('sp_list'));
    }
    
    
    
    /**
     * Edit SP
     *
     * @Route("/{id}/edit", name="purchase_change_status")
     * @Method("POST")
     * @Template("PurchaseBundle:Purchase:purchase_edit.html.twig")
     */
    public function changeStatusAction($id)
    {         
        $em = $this->get('doctrine_mongodb')->getManager();
        $purchase = $em->getRepository('PurchaseBundle:Purchase')->find($id);
        
        if($purchase->getStatus()->getPublicId() == PurchaseStatus::STATUS_FORMATION){
            $newStatus = $em->getRepository('PurchaseBundle:PurchaseStatus')->findOneByPublicId(PurchaseStatus::STATUS_ORDERS);
            $this->get('notification')->sendStatusChangedNotification($purchase, $purchase->getStatus(), $newStatus);
        }
        if($purchase->getStatus()->getPublicId() == PurchaseStatus::STATUS_ORDERS){
            $newStatus = $em->getRepository('PurchaseBundle:PurchaseStatus')->findOneByPublicId(PurchaseStatus::STATUS_STOP);
            $this->get('notification')->sendStatusChangedNotification($purchase, $purchase->getStatus(), $newStatus);
        }
        if($purchase->getStatus()->getPublicId() == PurchaseStatus::STATUS_STOP){
            $newStatus = $em->getRepository('PurchaseBundle:PurchaseStatus')->findOneByPublicId(PurchaseStatus::STATUS_EXPECTATION);
            $this->get('notification')->sendStatusChangedNotification($purchase, $purchase->getStatus(), $newStatus);
        }
        if($purchase->getStatus()->getPublicId() == PurchaseStatus::STATUS_EXPECTATION){
            $newStatus = $em->getRepository('PurchaseBundle:PurchaseStatus')->findOneByPublicId(PurchaseStatus::STATUS_PREPAYMENT);
            $this->get('notification')->sendStatusChangedNotification($purchase, $purchase->getStatus(), $newStatus);
        }
        if($purchase->getStatus()->getPublicId() == PurchaseStatus::STATUS_PREPAYMENT){
            $newStatus = $em->getRepository('PurchaseBundle:PurchaseStatus')->findOneByPublicId(PurchaseStatus::STATUS_PAYMENT);
            $this->get('notification')->sendStatusChangedNotification($purchase, $purchase->getStatus(), $newStatus);
        }
        if($purchase->getStatus()->getPublicId() == PurchaseStatus::STATUS_PAYMENT){
            $newStatus = $em->getRepository('PurchaseBundle:PurchaseStatus')->findOneByPublicId(PurchaseStatus::STATUS_ORDER_EXCPECTATION);
            $this->get('notification')->sendStatusChangedNotification($purchase, $purchase->getStatus(), $newStatus);
        }
        if($purchase->getStatus()->getPublicId() == PurchaseStatus::STATUS_ORDER_EXCPECTATION){
            $newStatus = $em->getRepository('PurchaseBundle:PurchaseStatus')->findOneByPublicId(PurchaseStatus::STATUS_DELIVERY);
            $this->get('notification')->sendStatusChangedNotification($purchase, $purchase->getStatus(), $newStatus);
        }
        if($purchase->getStatus()->getPublicId() == PurchaseStatus::STATUS_DELIVERY){
            $newStatus = $em->getRepository('PurchaseBundle:PurchaseStatus')->findOneByPublicId(PurchaseStatus::STATUS_DONE);
            $this->get('notification')->sendStatusChangedNotification($purchase, $purchase->getStatus(), $newStatus);
        }
        
        $purchase->setStatus($newStatus);
        $em->flush();
        
        return $this->redirect($this->generateUrl('purchase_detail', array('id' => $purchase->getId())));
    }
    
    /**
     * Edit SP's stop.
     *
     * @Route("/{id}/edit/stop", name="purchase_edit_stop")
     * @Template("PurchaseBundle:Purchase:purchase_edit_stop.html.twig")
     */
    public function stopEditAction(Request $request, $id)
    {        
        $em = $this->get('doctrine_mongodb')->getManager();

        $purchase = $em->getRepository('PurchaseBundle:Purchase')->find($id);

        if (!$purchase) {
            throw $this->createNotFoundException('Unable to find SP entity.');
        }
        
        $form   = $this->createForm(new PurchaseStopType(), $purchase);
        
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $em->persist($purchase);
                $em->flush();

                return $this->redirect($this->generateUrl('purchase_detail', array('id' => $id)));
            }
        }
        
        return array(
            'purchase'      => $purchase,
            'form'   => $form->createView(),
        );
    }
    
    /**
     * Edit SP's stop.
     *
     * @Route("/{id}/edit/attr", name="purchase_edit_attr")
     * @Template("PurchaseBundle:Purchase:purchase_edit_attr.html.twig")
     */
    public function editAttrAction(Request $request, $id)
    {        
        $em = $this->get('doctrine_mongodb')->getManager();

        $purchase = $em->getRepository('PurchaseBundle:Purchase')->find($id);

        if (!$purchase) {
            throw $this->createNotFoundException('Unable to find Purchase entity.');
        }
        
        $editForm = $this->createForm(new PurchaseType(), $purchase);
        
        if ($request->isMethod('POST')) {
            $editForm->bind($request);

            if ($editForm->isValid()) {
                $em->persist($purchase);
                $em->flush();

                return $this->redirect($this->generateUrl('purchase_detail', array('id' => $id)));
            }
        }
        
        return array(
            'purchase'      => $purchase,
            'form'   => $editForm->createView(),
        );
    }
    
    /**
     * Displays a form to edit an existing Category entity.
     *
     * @Route("/{purchaseId}/offers/{offerId}/", name="purchase_show_offer")
     * @Method("GET")
     * @Template("SPBundle:SP:sp_offer_show.html.twig")
     */
    public function offerDetailAction($purchaseId, $offerId)
    {
        $em = $this->get('doctrine_mongodb')->getManager();

        $offer = $em->getRepository('SPBundle:SPItem')->find($offer_id);

        if (!$offer) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }
        
        $orderItem = new OrderItem();
        $orderItemForm = $this->createForm(new OrderItemType(), $orderItem);
        
        $comment = new Comment();
        $commentForm   = $this->createForm(new CommentType(), $comment);

        return array(
            'offer'      => $offer,
            'sp' => $offer->getSp(),
            'comment_form' => $commentForm->createView(),
            'order_item_form' => $orderItemForm->createView(),
        );
    }
    
    /**
     * Creates a new Product entity.
     *
     * @Route("/{spId}/offers/{offerId}/", name="create_order_item")
     * @Method("POST")
     * @Template("SPBundle:SP:sp_offer_show.html.twig")
     */
    public function createOrderItemAction(Request $request, $spId, $offerId)
    {   
        $orderItem = new OrderItem();
        $orderItemForm = $this->createForm(new OrderItemType(), $orderItem);
        $orderItemForm->bind($request);

        if ($orderItemForm->isValid()) {
            $em = $this->get('doctrine_mongodb')->getManager();
            
            // устанавливаем текущего пользователя
            $user = $this->container->get('security.context')->getToken()->getUser();
        
            $purchase = $em->getRepository('SPBundle:SP')->find($spId);
            
            $offer = $em->getRepository('SPBundle:SPItem')->find($offerId);
            
            $order = $em->createQueryBuilder('SPBundle:Order')
                ->field('purchase.$id')->equals(new \MongoId($spId))
                ->field('user.$id')->equals(new \MongoId($user->getId()))
                ->getQuery()->getSingleResult();
             
            if (!$order) {
                $order = new Order();
                
                $em->persist($order);
                $em->persist($orderItem);
                
                $order->setPurchase($purchase);
                $order->setUser($user);
                
                $orderItem->setOffer($offer);
                $orderItem->setOrder($order);
                
                $em->flush();
            } else {
                $em->persist($orderItem);
                
                $order->setItems($orderItem);
                $orderItem->setOffer($offer);
                
                $em->flush();
            }          

            return $this->redirect($this->generateUrl('sp_offer_show', array('sp_id' => $purchase->getId(), 'offer_id' => $offer->getId())));
        }

        return array(
            'orderItem' => $orderItem,
            'order_item_form' => $orderItemForm->createView(),
        );
    }
    
    /**
     * Edit SP's stop.
     *
     * @Route("/{id}/create/offer", name="purchase_offer_create")
     * @Template("PurchaseBundle:Purchase:purchase_offer_create.html.twig")
     */
    public function createOfferAction(Request $request, $id)
    {        
        $offer = new Offer();
        
        $em = $this->get('doctrine_mongodb')->getManager();
        $purchase = $em->getRepository('PurchaseBundle:Purchase')->find($id);
        $offer->setPurchase($purchase); 
        
        $form   = $this->createForm(new OfferType(), $offer);
        
        if ($request->isMethod('POST')) {
             $form->bind($request);
        
            if ($form->isValid()) {
                $em = $this->get('doctrine_mongodb')->getManager();
                $offer->upload();
                $em->persist($offer);
                $em->flush();
                return $this->redirect($this->generateUrl('purchase_detail', array('id' => $id)));
            }
        }
        
        return array(
            'offer'      => $offer,
            'form'   => $form->createView(),
        );
    }
    
    /**
     * Displays a form to edit an existing Category entity.
     *
     * @Route("/{purchaseId}/offers/{offerId}/edit", name="purchase_edit_offer")
     * @Template("PurchaseBundle:Purchase:purchase_offer_edit.html.twig")
     */
    public function offerEditAction(Request $request, $purchaseId, $offerId)
    {
        $em = $this->get('doctrine_mongodb')->getManager();

        $offer = $em->getRepository('PurchaseBundle:Offer')->find($offerId);

        if (!$offer) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $editForm = $this->createForm(new OfferType(), $offer);
        
        if ($request->isMethod('POST')) {
            $editForm->bind($request);

            if ($editForm->isValid()) {
                $em->persist($offer);
                $em->flush();

                return $this->redirect($this->generateUrl('purchase_detail', array('id' => $purchaseId)));
            }
        }

        return array(
            'offer'      => $offer,
            'form'   => $editForm->createView(),
        );
    }
    
    /**
     * Up a SP entity.
     *
     * @Route("/{id}/up", name="sp_up")
     * @Method("GET")
     * @Template()
     */
    public function upAction($id)
    {        
        $em = $this->get('doctrine_mongodb')->getManager();

        $entity = $em->getRepository('SPBundle:SP')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SP entity.');
        }
        
        return array(
            'entity'      => $entity,
        );
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