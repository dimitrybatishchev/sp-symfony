<?php

namespace SP\NotificationBundle\Services;

use SP\NotificationBundle\Document\PurchaseCreatedNotification;

class NotificationService {
    
    protected $em;
    
    /*
     * Пользователя добавили в друзья
     */
    public function sendCommentToPurchaseAddedNotification($purchase) {

    }
    
    /*
     * Пользователя добавили в друзья
     */
    public function sendAddedAsFriendNotification($friendshipRequest) {
        $notification = new AddedAsFriendNotification();
        $notification->setDate(new \DateTime());
        $notification->setOwner($friendshipRequest->getSender());
        $notification->setAddedBy($friendshipRequest->getReceiver());
        $this->em->persist($notification);
    }
    
    /*
     * Изменился стутус у закупки
     */
    public function sendStatusChangedNotification($purchase, $oldStatus, $newStatus) {
        $orders = $purchase->getOrders();
        foreach ($orders as $order) {
            $user = $order->getUser();
            $notification = new StatusChangedNotification();
            $notification->setPurchase($purchase);
            $notification->setDate(new \DateTime());
            $notification->setOldStatus($oldStatus);
            $notification->setNewStatus($newStatus);
            $notification->setOwner($user);
            $this->em->persist($notification);
        }
    }
    
    /*
     * Создана новая закупка
     */
    public function sendPurchaseCreatedNotification($purchase) {
        $users = $this->em->getRepository('UserBundle:User')->findAll();
        foreach ($users as $user) {
            $notification = new PurchaseCreatedNotification();
            $notification->setPurchase($purchase);
            $notification->setDate(new \DateTime());
            $notification->setOwner($user);
            $this->em->persist($notification);
        }        
    }
    
    public function __construct(\Doctrine\ODM\MongoDB\DocumentManager $em){
        $this->em = $em;
    }
    
}