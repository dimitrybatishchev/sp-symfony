<?php

namespace SP\MarketResearchBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Vote
{
    /**
     * @MongoDB\Id
     */
    protected $id;
    
    /**
     * @MongoDB\ReferenceOne(targetDocument="SP\UserBundle\Document\User")
     */
    protected $user;
    
    /**
     * @MongoDB\ReferenceOne(targetDocument="SP\MarketResearchBundle\Document\MarketResearch")
     */
    protected $marketResearch;
    
    
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
    public function setUser(\SP\UserBundle\Document\User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get owner
     *
     * @return SP\UserBundle\Document\User $owner
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * Add owner
     *
     * @param SP\UserBundle\Document\User $owner
     */
    public function setMarketResearch(\SP\MarketResearchBundle\Document\MarketResearch $marketResearch)
    {
        $this->marketResearch = $marketResearch;
        return $this;
    }

    /**
     * Get owner
     *
     * @return SP\UserBundle\Document\User $owner
     */
    public function getMarketResearch()
    {
        return $this->marketResearch;
    }
}