<?php

namespace SP\NotificationBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 * @MongoDB\InheritanceType("SINGLE_COLLECTION")
 * @MongoDB\DiscriminatorField(fieldName="type")
 * @MongoDB\DiscriminatorMap({
 *      "basic"="Notification", 
 *      "purchase_created"="PurchaseCreatedNotification",
 *      "status_changed"="StatusChangedNotification",
 *      "added_as_friend"="AddedAsFriendNotification"
 * })
 */
abstract class Notification
{
    const TEMPLATE = '';
    
    /**
     * @MongoDB\Id  
     */
    protected $id;

    /**
     * @MongoDB\Date
     */
    protected $date;
    
    /**
     * @MongoDB\Boolean
     */
    protected $readed = FALSE;
    
    /**
     * @MongoDB\ReferenceOne(targetDocument="SP\UserBundle\Document\User")
     */
    protected $owner;
    
    /**
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return id $id
     */
    public function getTemplate()
    {
        return static::TEMPLATE;
    }
    
    /**
     * Set foreign_users
     *
     * @param boolean $foreignUsers
     * @return \SP
     */
    public function setReaded($readed)
    {
        $this->readed = $readed;
        return $this;
    }

    /**
     * Get foreign_users
     *
     * @return boolean $foreignUsers
     */
    public function getReaded()
    {
        return $this->readed;
    }
    
    
    /**
     * Add owner
     *
     * @param SP\UserBundle\Document\User $owner
     */
    public function setOwner(\SP\UserBundle\Document\User $owner)
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * Get owner
     *
     * @return SP\UserBundle\Document\User $owner
     */
    public function getOwner()
    {
        return $this->owner;
    }
    
    /**
     * @param date $created
     * @return \SP
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return date $created
     */
    public function getDate()
    {
        return $this->date;
    }
}
