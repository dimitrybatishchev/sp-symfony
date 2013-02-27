<?php

namespace SP\CatalogBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Category
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $name;
    
    /**
     * @MongoDB\ReferenceMany(targetDocument="SP\PurchaseBundle\Document\Purchase", inversedBy="categories")
     */
    private $purchases;
    
    public function __construct()
    {
        $this->purchases = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return \Product
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Add categories
     *
     * @param SP\SPBundle\Document\Comment $categories
     */
    public function setPurchases(\SP\PurchaseBundle\Document\Purchase $purchase)
    {
        $this->purchases[] = $purchase;
    }

    /**
     * Get categories
     *
     * @return Doctrine\Common\Collections\Collection $categories
     */
    public function getPurchases()
    {
        return $this->purchases;
    }

}
