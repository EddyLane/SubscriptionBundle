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
class InvoiceManager
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
} 