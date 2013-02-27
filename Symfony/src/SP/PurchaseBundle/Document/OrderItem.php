<?php

namespace SP\PurchaseBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class OrderItem
{
    /**
     * @MongoDB\Id
     */
    protected $id;
    
    /**
     * @MongoDB\String
     */
    protected $count;
    
    /**
     * @MongoDB\ReferenceOne(targetDocument="SP\PurchaseBundle\Document\Order", inversedBy="items")
     */
    private $order;
    
    /**
     * @MongoDB\ReferenceOne(targetDocument="SP\PurchaseBundle\Document\Offer", inversedBy="orderItems")
     */
    private $offer;
    
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
     * Set supplier
     *
     * @param string $supplier
     * @return \SP
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * Get supplier
     *
     * @return string $supplier
     */
    public function getOrder()
    {
        return $this->order;
    }
    
    /**
     * Set supplier
     *
     * @param string $supplier
     * @return \SP
     */
    public function setOffer($offer)
    {
        $this->offer = $offer;
        return $this;
    }

    /**
     * Get supplier
     *
     * @return string $supplier
     */
    public function getOffer()
    {
        return $this->offer;
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return \Product
     */
    public function setCount($count)
    {
        $this->count = $count;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getCount()
    {
        return $this->count;
    }
    
    
    
}
