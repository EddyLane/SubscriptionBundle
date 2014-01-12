<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 30/12/2013
 * Time: 11:52
 */
namespace Fridge\SubscriptionBundle\Model;

use Fridge\SubscriptionBundle\Model\CardInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface StripeProfileInterface
 * @package Fridge\SubscriptionBundle\Model
 */
interface StripeProfileInterface
{

    /**
     * @return mixed
     */
    public function getSubscriptionStart();

    /**
     * @param \DateTime $subscriptionEnd
     *                                   @return $this
     */
    public function setSubscriptionEnd(\DateTime $subscriptionEnd = null);

    /**
     * @return String
     */
    public function getStripeId();

    /**
     * @return mixed
     */
    public function getSubscriptionEnd();

    /**
     * @return Subscription
     */
    public function getSubscription();

    /**
     * @return int
     */
    public function getId();

    /**
     * @param Card $card
     *                   @return $this
     */
    public function addCard(CardInterface $card);

    /**
     * @return ArrayCollection
     */
    public function getCards();

    /**
     * @param \DateTime $subscriptionStart
     *                                     @return $this
     */
    public function setSubscriptionStart(\DateTime $subscriptionStart = null);

    /**
     * @param Subscription $subscription
     *                                   @return $this
     */
    public function setSubscription(SubscriptionInterface $subscription = null);

    /**
     * @param $stripeId
     * @return $this
     */
    public function setStripeId($stripeId);
}
