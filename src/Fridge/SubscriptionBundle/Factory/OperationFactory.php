<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 01/01/2014
 * Time: 16:09
 */

namespace Fridge\SubscriptionBundle\Factory;

use Fridge\SubscriptionBundle\Operation;
use Fridge\SubscriptionBundle\Proxy\StripeCustomer;
use Fridge\SubscriptionBundle\Proxy\StripePlan;

/**
 * Class OperationFactory
 * @package Fridge\SubscriptionBundle\Factory
 */
class OperationFactory
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
     * @param $operation
     * @return CreateCardOperation
     * @throws \InvalidArgumentException
     */
    public function get($operation)
    {
        switch($operation) {
            //Cards
            case 'card.create':
                return new Operation\CreateCardOperation($this->stripeCustomer, $this->stripePlan);
            case 'card.remove':
                return new Operation\RemoveCardOperation($this->stripeCustomer, $this->stripePlan);
            //Plans
            case 'plan.create':
                return new Operation\CreatePlanOperation($this->stripeCustomer, $this->stripePlan);
            case 'plan.remove':
                return new Operation\RemovePlanOperation($this->stripeCustomer, $this->stripePlan);
            //Subscriptions
            case 'subscription.update':
                return new Operation\UpdateSubscriptionOperation($this->stripeCustomer, $this->stripePlan);

            default:
                throw new \InvalidArgumentException('Unknown operation ' . $operation);
        }

    }


} 