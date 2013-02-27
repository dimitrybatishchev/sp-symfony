<?php

namespace SP\NotificationBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

use SP\NotificationBundle\Document\Notification;

/**
 * @MongoDB\Document
 */
class PurchaseCreatedNotification extends Notification
{
    const TEMPLATE = 'NotificationBundle:Notification:purchase_created.html.twig';
    
    /**
     * @MongoDB\ReferenceOne(targetDocument="SP\PurchaseBundle\Document\Purchase")
     */
    protected $purchase;
    
    /**
     * Set supplier
     *
     * @param string $supplier
     * @return \SP
     */
    public function setPurchase($purchase)
    {
        $this->purchase = $purchase;
        return $this;
    }

    /**
     * Get supplier
     *
     * @return string $supplier
     */
    public function getPurchase()
    {
        return $this->purchase;
    }

}
