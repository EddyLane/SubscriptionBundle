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
use Fridge\SubscriptionBundle\Proxy\StripeCard;

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
     * @var \Fridge\SubscriptionBundle\Proxy\StripeCard
     */
    protected $stripeCard;

    /**
     * @param StripeCustomer $stripeCustomer
     * @param StripePlan $stripePlan
     */
    public function __construct(StripeCustomer $stripeCustomer, StripePlan $stripePlan, StripeCard $stripeCard)
    {
        $this->stripeCustomer = $stripeCustomer;
        $this->stripeCard = $stripeCard;
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

            //Customer
            case 'customer.create':
                return new Operation\CreateCustomerOperation($this->stripeCustomer, $this->stripePlan, $this->stripeCard);
            case 'customer.update':
                return new Operation\UpdateCustomerOperation($this->stripeCustomer, $this->stripePlan, $this->stripeCard);

            case 'customer_and_card.create':
                return new Operation\CreateCustomerAndCardOperation($this->stripeCustomer, $this->stripePlan, $this->stripeCard);

            //Cards
            case 'card.create':
                return new Operation\CreateCardOperation($this->stripeCustomer, $this->stripePlan, $this->stripeCard);
            case 'card.remove':
                return new Operation\RemoveCardOperation($this->stripeCustomer, $this->stripePlan, $this->stripeCard);
            //Plans
            case 'plan.create':
                return new Operation\CreatePlanOperation($this->stripeCustomer, $this->stripePlan, $this->stripeCard);
            case 'plan.remove':
                return new Operation\RemovePlanOperation($this->stripeCustomer, $this->stripePlan, $this->stripeCard);
            //Subscriptions
            case 'subscription.update':
                return new Operation\UpdateSubscriptionOperation($this->stripeCustomer, $this->stripePlan, $this->stripeCard);
            case 'subscription.remove':
                return new Operation\RemoveSubscriptionOperation($this->stripeCustomer, $this->stripePlan, $this->stripeCard);

            default:
                throw new \InvalidArgumentException('Unknown operation ' . $operation);
        }

    }


} 