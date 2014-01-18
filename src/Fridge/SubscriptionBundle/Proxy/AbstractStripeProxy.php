<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 29/12/2013
 * Time: 01:59
 */

namespace Fridge\SubscriptionBundle\Proxy;

use Stripe;
use ZfrStripe\Client\StripeClient;

abstract class AbstractStripeProxy
{
    /**
     * @var \ZfrStripe\Client\StripeClient
     */
    protected $client;

    /**
     * @param $apiKey
     */
    public function __construct(StripeClient $client)
    {
        $this->client = $client;
    }

}
