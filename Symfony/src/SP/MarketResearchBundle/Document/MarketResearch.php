<?php

namespace SP\MarketResearchBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @MongoDB\Document
 */
class MarketResearch
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
     * @MongoDB\String
     */
    protected $description;
    
    /**
     * @MongoDB\ReferenceOne(targetDocument="SP\UserBundle\Document\User")
     */
    protected $owner;
    
    /**
     * @MongoDB\ReferenceMany(targetDocument="SP\PurchaseBundle\Document\Comment")
     */
    protected $comments;
    
    /**
     * @MongoDB\ReferenceMany(targetDocument="SP\UserBundle\Document\User")
     */
    protected $voted;
    
    /**
     * @MongoDB\Date
     */
    protected $created;
    
    /**
     * @MongoDB\String
     */
    protected $path;
    
    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;
    
    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->voted = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return \Post
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
     * Set name
     *
     * @param string $name
     * @return \Post
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getDescription()
    {
        return $this->description;
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
     * Add categories
     *
     * @param SP\SPBundle\Document\Comment $categories
     */
    public function setComments(\SP\PurchaseBundle\Document\Comment $comment)
    {
        $this->comments[] = $comment;
    }
    
    /**
     * Get owner
     *
     * @return SP\UserBundle\Document\User $owner
     */
    public function getVoted()
    {
        return $this->voted;
    }
    
        /**
     * Add categories
     *
     * @param SP\SPBundle\Document\Comment $categories
     */
    public function setVoted(\SP\UserBundle\Document\User $voted)
    {
        $this->voted[] = $voted;
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
     * Get categories
     *
     * @return Doctrine\Common\Collections\Collection $categories
     */
    public function getComments()
    {
        return $this->comments;
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
