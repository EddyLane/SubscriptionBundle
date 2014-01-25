<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 19/01/2014
 * Time: 17:24
 */

namespace Fridge\SubscriptionBundle\Model;

use Fridge\SubscriptionBundle\Model\Payment;
use Fridge\SubscriptionBundle\Model\Subscription;

abstract class Invoice
{
    /**
     * @var \Fridge\SubscriptionBundle\Model\Payment
     */
    protected $payment;

    /**
     * @var \Fridge\SubscriptionBundle\Model\Subscription
     */
    protected $subscription;

    /**
     * @var int
     */
    protected $amount;

    /**
     * @param Subscription $subscription
     * @return $this
     */
    public function setSubscription(Subscription $subscription)
    {
        $this->subscription = $subscription;

        return $this;
    }

    /**
     * @return \Fridge\SubscriptionBundle\Model\Subscription
     */
    public function getSubscription()
    {
        return $this->subscription;
    }
    /**
     * @param Payment $payment
     * @return $this
     */
    public function setPayment(Payment $payment)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * @return \Fridge\SubscriptionBundle\Model\Payment
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

} 