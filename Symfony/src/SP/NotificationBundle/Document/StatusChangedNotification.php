<?php

namespace SP\NotificationBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

use SP\NotificationBundle\Document\Notification;

/**
 * @MongoDB\Document
 */
class StatusChangedNotification extends Notification
{
    /**
     * @MongoDB\ReferenceOne(targetDocument="SP\PurchaseBundle\Document\PurchaseStatus")
     */
    protected $purchase;
    
    /**
     * @MongoDB\ReferenceOne(targetDocument="SP\PurchaseBundle\Document\PurchaseStatus")
     */
    protected $oldStatus;
    
    /**
     * @MongoDB\ReferenceOne(targetDocument="SP\PurchaseBundle\Document\PurchaseStatus")
     */
    protected $newStatus;
    
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
    }    /**
     * Add owner
     *
     * @param SP\UserBundle\Document\User $owner
     */
    public function setStatus(\SP\PurchaseBundle\Document\PurchaseStatus $status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get owner
     *
     * @return SP\PurchaseBundle\Document\PurchaseStatus $owner
     */
    public function getStatus()
    {
        return $this->status;
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
    
    /**
     * Add owner
     *
     * @param SP\UserBundle\Document\User $owner
     */
    public function setOldStatus(\SP\PurchaseBundle\Document\PurchaseStatus $oldStatus)
    {
        $this->oldStatus = $oldStatus;
        return $this;
    }

    /**
     * Get owner
     *
     * @return SP\PurchaseBundle\Document\PurchaseStatus $owner
     */
    public function getOldStatus()
    {
        return $this->oldStatus;
    }
    
        /**
     * Add owner
     *
     * @param SP\UserBundle\Document\User $owner
     */
    public function setNewStatus(\SP\PurchaseBundle\Document\PurchaseStatus $newStatus)
    {
        $this->newStatus = $newStatus;
        return $this;
    }

    /**
     * Get owner
     *
     * @return SP\PurchaseBundle\Document\PurchaseStatus $owner
     */
    public function getNewStatus()
    {
        return $this->newStatus;
    }
}
