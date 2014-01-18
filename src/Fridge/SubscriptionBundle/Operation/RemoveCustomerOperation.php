<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 18/01/2014
 * Time: 19:33
 */

namespace Fridge\SubscriptionBundle\Operation;

use Fridge\SubscriptionBundle\Model\StripeProfileInterface;
use ZfrStripe\Exception\CardErrorException;
use ZfrStripe\Exception\ServerErrorException;
use ZfrStripe\Exception\ValidationErrorException;

class RemoveCustomerOperation extends AbstractOperation
{
    /**
     * @param StripeProfileInterface $stripeProfile
     */
    public function getResult(StripeProfileInterface $stripeProfile)
    {
        if(!$stripeProfile->getStripeId()) {
            throw new \ErrorException('Profile already has no stripe ID');
        }

        $customerData = $this->stripeCustomer->remove([
            'id' => $stripeProfile->getStripeId()
        ]);
    }
} 