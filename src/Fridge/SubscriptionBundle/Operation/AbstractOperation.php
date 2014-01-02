<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 01/01/2014
 * Time: 15:15
 */

namespace Fridge\SubscriptionBundle\Operation;

use Fridge\SubscriptionBundle\Model\StripeProfileInterface;
use Fridge\SubscriptionBundle\Proxy\StripeCustomer;
use Fridge\SubscriptionBundle\Proxy\StripePlan;

/**
 * Class AbstractOperation
 * @package Fridge\SubscriptionBundle\Operation
 */
abstract class AbstractOperation
{
    /**
     * @var \Fridge\SubscriptionBundle\Proxy\StripeCustomer
     */
    protected $stripeCustomer;

    /**
     * @var \Fridge\SubscriptionBundle\Proxy\StripePlan
     */
    protected $stripePlan;

    /**
     * @param StripeCustomer $stripeCustomer
     * @param StripePlan $stripePlan
     */
    public function __construct(StripeCustomer $stripeCustomer, StripePlan $stripePlan)
    {
        $this->stripeCustomer = $stripeCustomer;
        $this->stripePlan = $stripePlan;
    }

    /**
     * @param StripeProfileInterface $stripeProfile
     * @return mixed
     */
    protected function getCustomer(StripeProfileInterface $stripeProfile)
    {
        return $this
            ->stripeCustomer
            ->retrieve($stripeProfile->getStripeId());
    }

} 