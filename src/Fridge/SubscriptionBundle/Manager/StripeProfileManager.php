<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 02/01/2014
 * Time: 22:51
 */

namespace Fridge\SubscriptionBundle\Manager;

/**
 * Class StripeProfileManager
 * @package Fridge\SubscriptionBundle\Manager
 */
class StripeProfileManager extends BaseManager
{
    /**
     * @param $stripeId
     * @return mixed
     */
    public function findOneByStripeId($stripeId)
    {
        return $this->getRepository()->findOneBy([
            'stripe_id' => $stripeId
        ]);
    }
} 