<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 01/01/2014
 * Time: 20:51
 */

namespace Fridge\SubscriptionBundle\Operation;


use Fridge\SubscriptionBundle\Model\StripeProfileInterface;

class UpdateSubscriptionOperation extends AbstractOperation
{
    public function getResult(StripeProfileInterface $stripeProfile)
    {
        try {

            $customer = $this->getCustomer($stripeProfile);

            $subscriptionData = $customer->updateSubscription([
                "plan" => $stripeProfile->getSubscription()->getId(),
                "prorate" => true
            ]);

            $stripeProfile->setSubscriptionStart(new \DateTime('@' . $subscriptionData['current_period_start']));
            $stripeProfile->setSubscriptionEnd(new \DateTime('@' . $subscriptionData['current_period_end']));

        } catch (\Stripe_CardError $e) {
            throw new FridgeCardDeclinedException($e, 400, $e->getMessage());
        }
    }
} 