<?php

namespace SP\HelperBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class FaqItem
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $question;
    
    /**
     * @MongoDB\String
     */
    protected $answer;
    

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
    public function setQuestion($question)
    {
        $this->question = $question;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getQuestion()
    {
        return $this->question;
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return \Product
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getAnswer()
    {
        return $this->answer;
    }

}
