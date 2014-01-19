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
use Fridge\SubscriptionBundle\Manager\PaymentManager;

/**
 * Class GetCustomerPaymentsOperation
 * @package Fridge\SubscriptionBundle\Operation
 */
class GetCustomerPaymentsOperation extends AbstractOperation
{
    /**
     * @var \Fridge\SubscriptionBundle\Manager\PaymentManager
     */
    protected $paymentManager;

    /**
     * @param PaymentManager $paymentManager
     * @param StripeCustomer $stripeCustomer
     * @param StripePlan $stripePlan
     * @param StripeCard $stripeCard
     */
    public function __construct(PaymentManager $paymentManager, StripeCustomer $stripeCustomer, StripePlan $stripePlan, StripeCard $stripeCard)
    {
        $this->paymentManager = $paymentManager;
        parent::__construct($stripeCustomer, $stripePlan, $stripeCard);
    }

    /**
     * @param StripeProfile $stripeProfile
     * @return array
     */
    public function getResult(StripeProfile $stripeProfile)
    {
        $stripeCharges = $this->stripeCustomer->getCharges([
            'customer' => $stripeProfile->getStripeId()
        ]);

        return array_map(function ($charge) use ($stripeProfile) {

            $payment = $this->paymentManager->create();
            $payment
                ->setAmount($charge['amount'])
                ->setCreatedAt(new \DateTime('@' . $charge['created']))
            ;

            $card = current(array_filter($stripeProfile->getCards()->toArray(), function ($card) use ($charge) {
                return $card->getToken() == $charge['card']['id'];
            }));


            if ($card) {
                $payment->setCard($card);
            }

            return $payment;

        }, $stripeCharges['data']);
    }
} 