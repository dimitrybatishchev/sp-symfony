<?php

namespace SP\UserMessagesBundle\Document;

use FOS\UserBundle\Document\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Message
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
     * @MongoDB\String
     */
    protected $body;
    
    /**
     * @MongoDB\Date
     */
    protected $sentTime;
    
    /**
     * @MongoDB\Boolean
     */
    protected $isRead = False;
    
    /**
     * @MongoDB\Boolean
     */
    protected $isDeleted = False;
    
    /**
     * @MongoDB\Date
     */
    protected $deleteTime;
    
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
     * Set description
     *
     * @param string $description
     * @return \SP
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }
    
    /**
     * Get description
     *
     * @return string $description
     */
    public function getBody()
    {
        return $this->body;
    }
    
    /**
     * Set created
     *
     * @param date $created
     * @return \SP
     */
    public function setSentTime($sentTime)
    {
        $this->sentTime = $sentTime;
        return $this;
    }

    /**
     * Get created
     *
     * @return date $created
     */
    public function getSentTime()
    {
        return $this->sentTime;
    }
    
    /**
     * Set size_is_garanted
     *
     * @param boolean $sizeIsGaranted
     * @return \SP
     */
    public function setIsRead($isRead)
    {
        $this->isRead = $isRead;
        return $this;
    }

    /**
     * Get size_is_garanted
     *
     * @return boolean $sizeIsGaranted
     */
    public function getIsRead()
    {
        return $this->isRead;
    }
    
    /**
     * Set size_is_garanted
     *
     * @param boolean $sizeIsGaranted
     * @return \SP
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }

    /**
     * Get size_is_garanted
     *
     * @return boolean $sizeIsGaranted
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }
    
    /**
     * Set created
     *
     * @param date $created
     * @return \SP
     */
    public function setDeleteTime($deleteTime)
    {
        $this->deleteTime = $deleteTime;
        return $this;
    }

    /**
     * Get created
     *
     * @return date $created
     */
    public function getDeleteTime()
    {
        return $this->deleteTime;
    }
    
}