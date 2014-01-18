<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 02/01/2014
 * Time: 21:11
 */

namespace Fridge\SubscriptionBundle\Proxy;

use Stripe_Event;

/**
 * Class StripeEvent
 * @package Fridge\SubscriptionBundle\Proxy
 */
class StripeEvent extends AbstractStripeProxy
{
    /**
     * @param array $data
     * @return array
     */
    public function retrieve(array $data)
    {
        return $this->client->getEvent($data);
    }
}