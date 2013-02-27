<?php

namespace SP\PurchaseBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Purchase
{
    /**
     * @MongoDB\Id
     */
    protected $id;
    /**
     * @MongoDB\String
     */
    protected $title;
    /**
     * @MongoDB\ReferenceOne(targetDocument="SP\GeoBundle\Document\City")
     */
    protected $city;
    
    /**
     * @MongoDB\Boolean
     */
    protected $foreignUsers;
    /**
     * @MongoDB\ReferenceMany(targetDocument="SP\CatalogBundle\Document\Category", mappedBy="purchases")
     */
    protected $categories;
    
    /**
     * @MongoDB\String
     */
    protected $fromSite;
    /**
     * @MongoDB\Boolean
     */
    protected $userCanAddOffers;
    
    /**
     * @MongoDB\Boolean
     */
    protected $colorIsGaranted;
    /**
     * @MongoDB\Boolean
     */
    protected $sizeIsGaranted;
    /**
     * @MongoDB\Boolean
     */
    protected $exchangeBrokenIsGaranted;
    /**
     * @MongoDB\Int
     */
    protected $profit;
    /**
     * @MongoDB\Boolean
     */
    protected $deliveryIncluded;
    /**
     * @MongoDB\ReferenceMany(targetDocument="SP\PurchaseBundle\Document\Transfer")
     */
    protected $moneyTransferTypes;   
    /**
     * @MongoDB\Int
     */
    protected $prepaymentAmount;
    /**
     * @MongoDB\ReferenceMany(targetDocument="SP\PurchaseBundle\Document\Delivery")
     */
    protected $deliveryTypes;
    
    /**
     * @MongoDB\String
     */
    protected $description;
    /**
     * @MongoDB\String
     */
    protected $supplier;
    /**
     * @MongoDB\Date
     */
    protected $created;
    /**
     * @MongoDB\ReferenceOne(targetDocument="SP\UserBundle\Document\User")
     */
    protected $owner;
    /**
     * @MongoDB\ReferenceOne(targetDocument="SP\PurchaseBundle\Document\PurchaseStatus")
     */
    protected $status;
    /**
     * @MongoDB\ReferenceMany(targetDocument="SP\PurchaseBundle\Document\Offer", mappedBy="purchase")
     */
    private $offers;
    /**
     * @MongoDB\ReferenceMany(targetDocument="SP\PurchaseBundle\Document\Order", mappedBy="purchase")
     */
    private $orders;
    /**
     * @MongoDB\Date
     */
    protected $stopDate;
    /**
     * @MongoDB\Int
     */
    protected $stopMinCount;
    /**
     * @MongoDB\Int
     */
    protected $stopSum;
    /**
     * @MongoDB\ReferenceMany(targetDocument="SP\PurchaseBundle\Document\Comment")
     */
    protected $comments;

    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->moneyTransferTypes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->deliveryTypes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->offers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->orders = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return \SP
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set city
     *
     * @param SP\SPBundle\Document\City $city
     * @return \SP
     */
    public function setCity(\SP\GeoBundle\Document\City $city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Get city
     *
     * @return SP\GeoBundle\Document\City $city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set foreign_users
     *
     * @param boolean $foreignUsers
     * @return \SP
     */
    public function setForeignUsers($foreignUsers)
    {
        $this->foreignUsers = $foreignUsers;
        return $this;
    }

    /**
     * Get foreign_users
     *
     * @return boolean $foreignUsers
     */
    public function getForeignUsers()
    {
        return $this->foreignUsers;
    }

    /**
     * Add categories
     *
     * @param SP\CatalogBundle\Document\Categories $categories
     */
    public function setCategories(\SP\CatalogBundle\Document\Category $categories)
    {
        $this->categories[] = $categories;
    }

    /**
     * Get categories
     *
     * @return Doctrine\Common\Collections\Collection $categories
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set from_site
     *
     * @param string $fromSite
     * @return \SP
     */
    public function setFromSite($fromSite)
    {
        $this->fromSite = $fromSite;
        return $this;
    }

    /**
     * Get from_site
     *
     * @return string $fromSite
     */
    public function getFromSite()
    {
        return $this->fromSite;
    }

    /**
     * Set user_can_add_offers
     *
     * @param boolean $userCanAddOffers
     * @return \SP
     */
    public function setUserCanAddOffers($userCanAddOffers)
    {
        $this->userCanAddOffers = $userCanAddOffers;
        return $this;
    }

    /**
     * Get user_can_add_offers
     *
     * @return boolean $userCanAddOffers
     */
    public function getUserCanAddOffers()
    {
        return $this->userCanAddOffers;
    }

    /**
     * Set color_is_garanted
     *
     * @param boolean $colorIsGaranted
     * @return \SP
     */
    public function setColorIsGaranted($colorIsGaranted)
    {
        $this->colorIsGaranted = $colorIsGaranted;
        return $this;
    }

    /**
     * Get color_is_garanted
     *
     * @return boolean $colorIsGaranted
     */
    public function getColorIsGaranted()
    {
        return $this->colorIsGaranted;
    }

    /**
     * Set size_is_garanted
     *
     * @param boolean $sizeIsGaranted
     * @return \SP
     */
    public function setSizeIsGaranted($sizeIsGaranted)
    {
        $this->sizeIsGaranted = $sizeIsGaranted;
        return $this;
    }

    /**
     * Get size_is_garanted
     *
     * @return boolean $sizeIsGaranted
     */
    public function getSizeIsGaranted()
    {
        return $this->sizeIsGaranted;
    }

    /**
     * Set exchange_broken_is_garanted
     *
     * @param boolean $exchangeBrokenIsGaranted
     * @return \SP
     */
    public function setExchangeBrokenIsGaranted($exchangeBrokenIsGaranted)
    {
        $this->exchangeBrokenIsGaranted = $exchangeBrokenIsGaranted;
        return $this;
    }

    /**
     * Get exchange_broken_is_garanted
     *
     * @return boolean $exchangeBrokenIsGaranted
     */
    public function getExchangeBrokenIsGaranted()
    {
        return $this->exchangeBrokenIsGaranted;
    }

    /**
     * Set profit
     *
     * @param int $profit
     * @return \SP
     */
    public function setProfit($profit)
    {
        $this->profit = $profit;
        return $this;
    }

    /**
     * Get profit
     *
     * @return int $profit
     */
    public function getProfit()
    {
        return $this->profit;
    }

    /**
     * Set delivery_included
     *
     * @param boolean $deliveryIncluded
     * @return \SP
     */
    public function setDeliveryIncluded($deliveryIncluded)
    {
        $this->deliveryIncluded = $deliveryIncluded;
        return $this;
    }

    /**
     * Get delivery_included
     *
     * @return boolean $deliveryIncluded
     */
    public function getDeliveryIncluded()
    {
        return $this->deliveryIncluded;
    }

    /**
     * Add money_transfer_types
     *
     * @param SP\SPBundle\Document\Transfer $moneyTransferTypes
     */
    public function setMoneyTransferTypes(\SP\PurchaseBundle\Document\Transfer $moneyTransferTypes)
    {
        $this->moneyTransferTypes[] = $moneyTransferTypes;
    }

    /**
     * Get money_transfer_types
     *
     * @return Doctrine\Common\Collections\Collection $moneyTransferTypes
     */
    public function getMoneyTransferTypes()
    {
        return $this->moneyTransferTypes;
    }

    /**
     * Set prepayment_amount
     *
     * @param int $prepaymentAmount
     * @return \SP
     */
    public function setPrepaymentAmount($prepaymentAmount)
    {
        $this->prepaymentAmount = $prepaymentAmount;
        return $this;
    }

    /**
     * Get prepayment_amount
     *
     * @return int $prepaymentAmount
     */
    public function getPrepaymentAmount()
    {
        return $this->prepaymentAmount;
    }

    /**
     * Add delivery_types
     *
     * @param SP\SPBundle\Document\Delivery $deliveryTypes
     */
    public function setDeliveryTypes(\SP\PurchaseBundle\Document\Delivery $deliveryTypes)
    {
        $this->deliveryTypes[] = $deliveryTypes;
    }

    /**
     * Get delivery_types
     *
     * @return Doctrine\Common\Collections\Collection $deliveryTypes
     */
    public function getDeliveryTypes()
    {
        return $this->deliveryTypes;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return \SP
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set supplier
     *
     * @param string $supplier
     * @return \SP
     */
    public function setSupplier($supplier)
    {
        $this->supplier = $supplier;
        return $this;
    }

    /**
     * Get supplier
     *
     * @return string $supplier
     */
    public function getSupplier()
    {
        return $this->supplier;
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
     * Add owner
     *
     * @param SP\UserBundle\Document\User $owner
     */
    public function setStatus(\SP\PurchaseBundle\Document\PurchaseStatus $status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get owner
     *
     * @return SP\PurchaseBundle\Document\PurchaseStatus $owner
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Add categories
     *
     * @param SP\CatalogBundle\Document\Categories $categories
     */
    public function setOffers(\SP\PurchaseBundle\Document\Offer $offers)
    {
        $this->offers[] = $offers;
    }

    /**
     * Get categories
     *
     * @return Doctrine\Common\Collections\Collection $categories
     */
    public function getOffers()
    {
        return $this->offers;
    }
    
    /**
     * Add categories
     *
     * @param SP\CatalogBundle\Document\Categories $categories
     */
    public function setOrders(\SP\PurchaseBundle\Document\Order $order)
    {
        $this->orders[] = $orders;
    }

    /**
     * Get categories
     *
     * @return Doctrine\Common\Collections\Collection $categories
     */
    public function getOrders()
    {
        return $this->orders;
    }
    
    /**
     * Set created
     *
     * @param date $created
     * @return \SP
     */
    public function setStopDate($stopDate)
    {
        $this->stopDate = $stopDate;
        return $this;
    }

    /**
     * Get created
     *
     * @return date $created
     */
    public function getStopDate()
    {
        return $this->stopDate;
    }
    
    /**
     * Set prepayment_amount
     *
     * @param int $prepaymentAmount
     * @return \SP
     */
    public function setStopSum($stopSum)
    {
        $this->stopSum = $stopSum;
        return $this;
    }

    /**
     * Get prepayment_amount
     *
     * @return int $prepaymentAmount
     */
    public function getStopSum()
    {
        return $this->stopSum;
    }
    
    /**
     * Set prepayment_amount
     *
     * @param int $prepaymentAmount
     * @return \SP
     */
    public function setStopMinCount($stopMinCount)
    {
        $this->stopMinCount = $stopMinCount;
        return $this;
    }

    /**
     * Get prepayment_amount
     *
     * @return int $prepaymentAmount
     */
    public function getStopMinCount()
    {
        return $this->stopMinCount;
    }
      
    /**
     * Add categories
     *
     * @param SP\SPBundle\Document\Comment $categories
     */
    public function setComments(\SP\PurchaseBundle\Document\Comment $comment)
    {
        $this->comments[] = $comment;
    }

    /**
     * Get categories
     *
     * @return Doctrine\Common\Collections\Collection $categories
     */
    public function getComments()
    {
        return $this->comments;
    }
    
}
