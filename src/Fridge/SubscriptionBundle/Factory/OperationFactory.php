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
use Fridge\SubscriptionBundle\Manager\PaymentManager;
use Fridge\SubscriptionBundle\Manager\InvoiceManager;
use Fridge\SubscriptionBundle\Manager\BaseManager;

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
     * @var \Fridge\SubscriptionBundle\Manager\PaymentManager
     */
    protected $paymentManager;

    /**
     * @var \Fridge\SubscriptionBundle\Manager\InvoiceManager
     */
    protected $invoiceManager;

    /**
     * @var \Fridge\SubscriptionBundle\Manager\SubscriptionManager
     */
    protected $subscriptionManager;

    /**
     * @param StripeCustomer $stripeCustomer
     * @param StripePlan $stripePlan
     * @param StripeCard $stripeCard
     * @param PaymentManager $paymentManager
     * @param InvoiceManager $invoiceManager
     * @param SubscriptionManager $subscriptionManager
     */
    public function __construct(StripeCustomer $stripeCustomer, StripePlan $stripePlan, StripeCard $stripeCard, PaymentManager $paymentManager, InvoiceManager $invoiceManager, BaseManager $subscriptionManager)
    {
        $this->stripeCustomer = $stripeCustomer;
        $this->stripeCard = $stripeCard;
        $this->stripePlan = $stripePlan;
        $this->paymentManager = $paymentManager;
        $this->invoiceManager = $invoiceManager;
        $this->subscriptionManager = $subscriptionManager;
    }

    /**
     * @param $operation
     * @return Operation\CreateCardOperation|Operation\CreateCustomerAndCardOperation|Operation\CreateCustomerOperation|Operation\CreatePlanOperation|Operation\GetCustomerInvoicesOperation|Operation\GetCustomerPaymentsOperation|Operation\RemoveCardOperation|Operation\RemoveCustomerOperation|Operation\RemovePlanOperation|Operation\RemoveSubscriptionOperation|Operation\UpdateCustomerOperation|Operation\UpdateSubscriptionOperation
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
            case 'customer.remove':
                return new Operation\RemoveCustomerOperation($this->stripeCustomer, $this->stripePlan, $this->stripeCard);
            case 'customer.charges.get':
                return new Operation\GetCustomerPaymentsOperation($this->paymentManager, $this->stripeCustomer, $this->stripePlan, $this->stripeCard);
            case 'customer.invoices.get':
                return new Operation\GetCustomerInvoicesOperation($this->invoiceManager, $this->subscriptionManager, $this->stripeCustomer, $this->stripePlan, $this->stripeCard);
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