<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 01/01/2014
 * Time: 20:51
 */

namespace Fridge\SubscriptionBundle\Operation;

use Fridge\SubscriptionBundle\Model\StripeProfileInterface;
use ZfrStripe\Exception\CardErrorException;
use ZfrStripe\Exception\ServerErrorException;
use ZfrStripe\Exception\ValidationErrorException;

class UpdateSubscriptionOperation extends AbstractOperation
{
    public function getResult(StripeProfileInterface $stripeProfile)
    {
        try {
            $subscriptionData = $this->stripeCustomer->updateSubscription([
                'customer' => $stripeProfile->getStripeId(),
                'plan' => $stripeProfile->getSubscription()->getId()
            ]);

            $stripeProfile->setSubscriptionStart(new \DateTime('@' . $subscriptionData['current_period_start']));
            $stripeProfile->setSubscriptionEnd(new \DateTime('@' . $subscriptionData['current_period_end']));

        } catch (CardErrorException $e) {
            throw new FridgeCardDeclinedException($e, 400, $e->getMessage());
        }

    }
} 