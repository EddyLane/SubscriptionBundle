<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 19/01/2014
 * Time: 18:14
 */

namespace Fridge\SubscriptionBundle\Manager;

/**
 * Class PaymentManager
 * @package Fridge\SubscriptionBundle\Manager
 */
class PaymentManager implements ManagerInterface
{
    /**
     * @var string
     */
    protected $baseClass;

    /**
     * @param $baseClass
     */
    public function __construct($baseClass)
    {
        $this->baseClass = $baseClass;
    }

    /**
     * @param null $constructWith
     * @return mixed
     */
    public function create($constructWith = null)
    {
        return new $this->baseClass($constructWith);
    }

    /**
     * @param $entity
     * @param bool $flush
     * @return mixed|void
     */
    public function save($entity, $flush = true) {}

    /**
     * @param $entity
     * @param bool $flush
     * @return mixed|void
     */
    public function remove($entity, $flush = true) {}
} 