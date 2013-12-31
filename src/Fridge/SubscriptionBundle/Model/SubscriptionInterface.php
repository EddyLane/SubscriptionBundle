<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 30/12/2013
 * Time: 11:56
 */
namespace Fridge\SubscriptionBundle\Model;

use Fridge\SubscriptionBundle\Entity\Subscription;

/**
 * Interface SubscriptionInterface
 * @package Fridge\SubscriptionBundle\Model
 */
interface SubscriptionInterface
{
    /**
     * Get price
     *
     * @return string
     */
    public function getPrice();

    /**
     * Set description
     *
     * @param  string       $description
     * @return Subscription
     */
    public function setDescription($description);

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Set price
     *
     * @param  string       $price
     * @return Subscription
     */
    public function setPrice($price);

    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set name
     *
     * @param  string       $name
     * @return Subscription
     */
    public function setName($name);
}
