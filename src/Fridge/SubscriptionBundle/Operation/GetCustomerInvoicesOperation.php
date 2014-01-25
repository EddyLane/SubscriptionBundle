<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 19/01/2014
 * Time: 15:46
 */

namespace Fridge\SubscriptionBundle\Operation;

use Fridge\SubscriptionBundle\Entity\StripeProfile;
use Fridge\SubscriptionBundle\Entity\Payment;
use Fridge\SubscriptionBundle\Proxy\StripeCustomer;
use Fridge\SubscriptionBundle\Proxy\StripePlan;
use Fridge\SubscriptionBundle\Proxy\StripeCard;
use Fridge\SubscriptionBundle\Manager\InvoiceManager;
use Fridge\SubscriptionBundle\Manager\ManagerInterface;

/**
 * Class GetCustomerPaymentsOperation
 * @package Fridge\SubscriptionBundle\Operation
 */
class GetCustomerInvoicesOperation extends AbstractOperation
{
    /**
     * @var \Fridge\SubscriptionBundle\Manager\InvoiceManager
     */
    protected $invoiceManager;

    /**
     * @var \Fridge\SubscriptionBundle\Manager\SubscriptionManager
     */
    protected $subscriptionManager;

    /**
     * @param PaymentManager $invoiceManager
     * @param StripeCustomer $stripeCustomer
     * @param StripePlan $stripePlan
     * @param StripeCard $stripeCard
     */
    public function __construct(InvoiceManager $invoiceManager, ManagerInterface $subscriptionManager, StripeCustomer $stripeCustomer, StripePlan $stripePlan, StripeCard $stripeCard)
    {
        $this->invoiceManager = $invoiceManager;
        $this->subscriptionManager = $subscriptionManager;
        parent::__construct($stripeCustomer, $stripePlan, $stripeCard);
    }

    /**
     * @param StripeProfile $stripeProfile
     * @return array
     */
    public function getResult(StripeProfile $stripeProfile)
    {

        $stripeCharges = $this->stripeCustomer->getInvoices([
            'customer' => $stripeProfile->getStripeId()
        ]);

        $subscriptions = $this->subscriptionManager->findAll();

        return array_map(function ($charge) use ($subscriptions) {

            $invoice = $this->invoiceManager->create();

            $invoice
                ->setAmount($charge['amount'])
            ;

            $subscription = current(array_filter($subscriptions, function ($subscription) use ($charge) {
                return $subscription->getName() === $charge['plan']['name'];
            }));

            if ($subscription) {
                $invoice->setSubscription($subscription);
            }

            return $invoice;

        }, $stripeCharges['data'][0]['lines']['data']);
    }
} 