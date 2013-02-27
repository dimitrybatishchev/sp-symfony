<?php

namespace SP\PurchaseBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class PurchaseStatus
{
        // Формирование
        const STATUS_FORMATION = 9;
        // Прием заказов
        const STATUS_ORDERS = 8;
        // Стоп заказа
        const STATUS_STOP = 7;
        // Ожидание ответа от поставщика
        const STATUS_EXPECTATION = 6;
        // Предоплата
        const STATUS_PREPAYMENT = 5;
        // Оплата счета
        const STATUS_PAYMENT = 4;
        // Ожидание заказа
        const STATUS_ORDER_EXCPECTATION = 3;
        // Раздача заказов
        const STATUS_DELIVERY = 2;
        // Завершено
        const STATUS_DONE = 1;
        // Отменено
        const STATUS_DECLINE = 0;
        
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $name;
    
    /**
     * @MongoDB\Int
     */
    protected $publicId;
    
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
     * Set name
     *
     * @param string $name
     * @return \Product
     */
    public function setPublicId($publicId)
    {
        $this->publicId = $publicId;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getPublicId()
    {
        return $this->publicId;
    }
    
}
