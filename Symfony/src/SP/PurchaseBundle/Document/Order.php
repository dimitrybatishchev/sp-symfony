<?php

namespace SP\PurchaseBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Order
{
    /**
     * @MongoDB\Id
     */
    protected $id;
    
    /**
     * @MongoDB\ReferenceOne(targetDocument="SP\PurchaseBundle\Document\Purchase", inversedBy="orders")
     */
    private $purchase;
    
    /**
     * @MongoDB\ReferenceOne(targetDocument="SP\UserBundle\Document\User")
     */
    protected $user;
    
    /**
     * @MongoDB\ReferenceMany(targetDocument="SP\PurchaseBundle\Document\OrderItem", mappedBy="order")
     */
    private $items;
    
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
    public function setPurchase($purchase)
    {
        $this->purchase = $purchase;
        return $this;
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
     * Add categories
     *
     * @param SP\CatalogBundle\Document\Categories $categories
     */
    public function setItems(\SP\PurchaseBundle\Document\OrderItem $item)
    {
        $this->items[] = $item;
    }

    /**
     * Get categories
     *
     * @return Doctrine\Common\Collections\Collection $categories
     */
    public function getItems()
    {
        return $this->items;
    }
}
