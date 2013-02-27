<?php

namespace SP\UserBundle\Document;

use FOS\UserBundle\Document\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @MongoDB\Document
 */
class User extends BaseUser
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;
    
    /**
     * @MongoDB\String
     */
    protected $avatar;

    /**
     * @MongoDB\String
     */
    protected $firstname;
    
    /**
     * @MongoDB\String
     */
    protected $middlename;
    
    /**
     * @MongoDB\Date
     */
    protected $birthDay;
    
    /**
     * @MongoDB\String
     */
    protected $icq;
    
    /**
     * @MongoDB\String
     */
    protected $site;
    
    /**
     * @MongoDB\String
     */
    protected $skype;

    /**
     * @MongoDB\String
     */
    protected $legalPerson;
    
    /**
     * @MongoDB\String
     */
    protected $requisites;
    
    /**
     * @MongoDB\String
     */
    protected $path;
    
    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;
    
    /**
     * @MongoDB\String
     */
    protected $lastname;
    
    /**
     * @MongoDB\ReferenceMany(targetDocument="SP\UserBundle\Document\User")
     */
    protected $friends;

    public function __construct()
    {
        parent::__construct();
        $this->friends = new \Doctrine\Common\Collections\ArrayCollection();
        $this->notifications = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set firstname
     *
     * @param string $firstname
     * @return \User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string $firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }
    
    /**
     * Set firstname
     *
     * @param string $middlename
     * @return \User
     */
    public function setMiddlename($middlename)
    {
        $this->middlename = $middlename;
        return $this;
    }

    /**
     * Get middlename
     *
     * @return string $middlename
     */
    public function getMiddlename()
    {
        return $this->middlename;
    }
    
    /**
     * Set firstname
     *
     * @param string $lastname
     * @return \User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string $lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }
    
    /**
     * Add categories
     *
     * @param SP\SPBundle\Document\Comment $categories
     */
    public function setFriends(\SP\UserBundle\Document\User $user)
    {
        $this->friends[] = $user;
    }

    /**
     * Get categories
     *
     * @return Doctrine\Common\Collections\Collection $categories
     */
    public function getFriends()
    {
        return $this->friends;
    }
    
    /**
     * Set created
     *
     * @param date $created
     * @return \SP
     */
    public function setBirthDay($birthDay)
    {
        $this->birthDay = $birthDay;
        return $this;
    }

    /**
     * Get created
     *
     * @return date $created
     */
    public function getBirthDay()
    {
        return $this->birthDay;
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