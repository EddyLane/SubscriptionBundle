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
use Fridge\SubscriptionBundle\Proxy\StripeCard;
use ZfrStripe\Client\StripeClient;

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
     * @var \Fridge\SubscriptionBundle\Proxy\StripeCard
     */
    protected $stripeCard;

    /**
     * @var \Fridge\SubscriptionBundle\Proxy\StripePlan
     */
    protected $stripePlan;

    /**
     * @param StripeCustomer $stripeCustomer
     * @param StripePlan $stripePlan
     * @param StripeCard $stripeCard
     */
    public function __construct(StripeCustomer $stripeCustomer, StripePlan $stripePlan, StripeCard $stripeCard)
    {
        $this->stripeCustomer = $stripeCustomer;
        $this->stripePlan = $stripePlan;
        $this->stripeCard = $stripeCard;
    }

} 