<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 29/12/2013
 * Time: 01:59
 */

namespace Fridge\SubscriptionBundle\Proxy;

use Stripe;

abstract class AbstractStripeProxy
{
    /**
     * @param $apiKey
     */
    public function setApiKey($apiKey)
    {
        Stripe::setApiKey($apiKey);
    }
}
