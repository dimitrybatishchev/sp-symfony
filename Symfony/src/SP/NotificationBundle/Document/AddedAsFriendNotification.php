<?php

namespace SP\NotificationBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

use SP\NotificationBundle\Document\Notification;

/**
 * @MongoDB\Document
 */
class AddedAsFriendNotification extends Notification
{
    /**
     * @MongoDB\ReferenceOne(targetDocument="SP\UserBundle\Document\User")
     */
    protected $addedBy;
    
    /**
     * Set supplier
     *
     * @param string $supplier
     * @return \SP
     */
    public function setAddedBy($addedBy)
    {
        $this->addedBy = $addedBy;
        return $this;
    }

    /**
     * Get supplier
     *
     * @return string $supplier
     */
    public function getAddedBy()
    {
        return $this->addedBy;
    }

}
