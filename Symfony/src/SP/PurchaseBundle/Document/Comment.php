<?php

namespace SP\PurchaseBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Comment
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $body;
    
    /**
     * @MongoDB\ReferenceOne(targetDocument="SP\UserBundle\Document\User")
     */
    protected $writer;
    
    /**
     * @MongoDB\Date
     */
    protected $created;
    
    
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
     * Set name
     *
     * @param string $name
     * @return \Product
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getBody()
    {
        return $this->body;
    }
    
    /**
     * Add owner
     *
     * @param SP\UserBundle\Document\User $owner
     */
    public function setWriter(\SP\UserBundle\Document\User $writer)
    {
        $this->writer = $writer;
        return $this;
    }

    /**
     * Get owner
     *
     * @return SP\UserBundle\Document\User $owner
     */
    public function getWriter()
    {
        return $this->writer;
    }
    
    /**
     * Set created
     *
     * @param date $created
     * @return \SP
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * Get created
     *
     * @return date $created
     */
    public function getCreated()
    {
        return $this->created;
    }
    
}
