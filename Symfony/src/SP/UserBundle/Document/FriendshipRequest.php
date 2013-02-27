<?php

namespace SP\UserBundle\Document;

use FOS\UserBundle\Document\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class FriendshipRequest
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;
    
    /**
     * @MongoDB\ReferenceOne(targetDocument="SP\UserBundle\Document\User")
     */
    protected $sender;
    
    /**
     * @MongoDB\ReferenceOne(targetDocument="SP\UserBundle\Document\User")
     */
    protected $receiver;
    
    /**
     * @MongoDB\Boolean
     */
    protected $isConfirmed;
    
    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Add owner
     *
     * @param SP\UserBundle\Document\User $owner
     */
    public function setSender(\SP\UserBundle\Document\User $sender)
    {
        $this->sender = $sender;
        return $this;
    }

    /**
     * Get owner
     *
     * @return SP\UserBundle\Document\User $owner
     */
    public function getSender()
    {
        return $this->sender;
    }
    
    /**
     * Add owner
     *
     * @param SP\UserBundle\Document\User $owner
     */
    public function setReceiver(\SP\UserBundle\Document\User $receiver)
    {
        $this->receiver = $receiver;
        return $this;
    }

    /**
     * Get owner
     *
     * @return SP\UserBundle\Document\User $owner
     */
    public function getReceiver()
    {
        return $this->receiver;
    }
    
    /**
     * Set size_is_garanted
     *
     * @param boolean $sizeIsGaranted
     * @return \SP
     */
    public function setIsConfirmed($isConfirmed)
    {
        $this->isConfirmed = $isConfirmed;
        return $this;
    }

    /**
     * Get size_is_garanted
     *
     * @return boolean $sizeIsGaranted
     */
    public function getIsConfirmed()
    {
        return $this->isConfirmed;
    }

}