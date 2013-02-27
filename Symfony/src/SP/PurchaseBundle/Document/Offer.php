<?php

namespace SP\PurchaseBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @MongoDB\Document
 */
class Offer
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
     * @MongoDB\String
     */
    protected $codeNumber;
    
    /**
     * @MongoDB\String
     */
    protected $description;
    
    /**
     * @MongoDB\String
     */
    protected $price;
    
    /**
     * @MongoDB\String
     */
    protected $count;
    
    /**
     * @MongoDB\String
     */
    protected $path;
    
    /**
     * @MongoDB\ReferenceMany(targetDocument="SP\PurchaseBundle\Document\OrderItem", mappedBy="offer")
     */
    private $orderItems;
    
    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;
    
    /**
     * @MongoDB\ReferenceOne(targetDocument="SP\PurchaseBundle\Document\Purchase", inversedBy="offers")
     */
    private $purchase;
    
    /**
     * @MongoDB\ReferenceMany(targetDocument="SP\PurchaseBundle\Document\Comment")
     */
    protected $comments;

    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *Title
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
     * @return \SPItem
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
     * Set title
     *
     * @param string $title
     * @return \SPItem
     */
    public function setCodeNumber($codeNumber)
    {
        $this->codeNumber = $codeNumber;
        return $this;
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getCodeNumber()
    {
        return $this->codeNumber;
    }
    
    /**
     * Set title
     *
     * @param string $title
     * @return \SPItem
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Set title
     *
     * @param string $title
     * @return \SPItem
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getPrice()
    {
        return $this->price;
    }
    
    /**
     * Set title
     *
     * @param string $title
     * @return \SPItem
     */
    public function setCount($count)
    {
        $this->count = $count;
        return $this;
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getCount()
    {
        return $this->count;
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
    
    /**
     * Add categories
     *
     * @param SP\CatalogBundle\Document\Categories $categories
     */
    public function setOrderItems(\SP\PurchaseBundle\Document\OrderItem $item)
    {
        $this->orderItems[] = $item;
    }

    /**
     * Get categories
     *
     * @return Doctrine\Common\Collections\Collection $categories
     */
    public function getOrderItems()
    {
        return $this->orderItems;
    }
    
    
    public function getFile() {
        return $this->file;
    }

    public function setFile($file) {
        $this->file = $file;
    }

    public function getPath() {
        return $this->path;
    }

    public function setPath($path) {
        $this->path = $path;
    }
    
    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : '/'.$this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/documents';
    }
    
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->file) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        $this->file->move(
            $this->getUploadRootDir(),
            $this->file->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->path = $this->file->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }
}
