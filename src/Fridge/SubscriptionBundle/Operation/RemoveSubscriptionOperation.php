<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 02/01/2014
 * Time: 22:21
 */

namespace Fridge\SubscriptionBundle\Operation;

use Fridge\SubscriptionBundle\Model\StripeProfileInterface;

/**
 * Class RemoveSubscriptionOperation
 * @package Fridge\SubscriptionBundle\Operation
 */
class RemoveSubscriptionOperation extends AbstractOperation
{

    /**
     * @param StripeProfileInterface $stripeProfile
     * @throws FridgeCardDeclinedException
     */
    public function getResult(StripeProfileInterface $stripeProfile)
    {
        $this->stripeCustomer->cancelSubscription([
            'id' => $stripeProfile->getStripeId()
        ]);

        $stripeProfile->setSubscriptionStart(null);
        $stripeProfile->setSubscriptionEnd(null);
    }

} 