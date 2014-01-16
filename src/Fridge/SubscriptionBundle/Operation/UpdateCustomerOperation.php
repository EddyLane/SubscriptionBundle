<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 05/01/2014
 * Time: 15:13
 */

namespace Fridge\SubscriptionBundle\Operation;

use Fridge\SubscriptionBundle\Exception\FridgeCardDeclinedException;
use Fridge\SubscriptionBundle\Model\StripeProfileInterface;

/**
 * Class CreateCustomerOperation
 * @package Fridge\SubscriptionBundle\Operation
 */
class UpdateCustomerOperation extends AbstractOperation
{
    /**
     * @param StripeProfileInterface $stripeProfile
     */
    public function getResult(StripeProfileInterface $stripeProfile)
    {
        if(!$stripeProfile->getStripeId()) {
            throw new \ErrorException('Profile has not been persisted to stripe');
        }

        try {
            $stripeCustomer = $this->getCustomer($stripeProfile);

            $stripeCustomer->default_card = $stripeProfile->getDefaultCard()->getToken();

            $stripeCustomer->save();
        }
        catch(\Stripe_Error $e) {
            throw new FridgeCardDeclinedException($e->getMessage());
        }

    }
} 