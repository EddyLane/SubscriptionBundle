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
use ZfrStripe\Exception\CardErrorException;
use ZfrStripe\Exception\ServerErrorException;
use ZfrStripe\Exception\ValidationErrorException;

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

        $this->stripeCustomer->update([
            'id' => $stripeProfile->getStripeId(),
            'default_card' => $stripeProfile->getDefaultCard()->getToken()
        ]);

    }
} 