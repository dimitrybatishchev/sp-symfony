<?php

namespace SP\HelperBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Feedback
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $subject;
    
    /**
     * @MongoDB\String
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
     * Set name
     *
     * @param string $name
     * @return \Product
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getSubject()
    {
        return $this->subject;
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return \Product
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getMessage()
    {
        return $this->message;
    }

}
