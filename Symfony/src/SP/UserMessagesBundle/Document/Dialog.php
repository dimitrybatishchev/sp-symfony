<?php

namespace SP\UserMessagesBundle\Document;

use FOS\UserBundle\Document\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Dialog
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
     * @MongoDB\ReferenceOne(targetDocument="SP\UserMessagesBundle\Document\Message")
     */
    protected $message;
    
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
     * Add owner
     *
     * @param SP\UserBundle\Document\User $owner
     */
    public function setMessage(\SP\UserMessagesBundle\Document\Message $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Get owner
     *
     * @return SP\UserBundle\Document\User $owner
     */
    public function getMessage()
    {
        return $this->message;
    }
}