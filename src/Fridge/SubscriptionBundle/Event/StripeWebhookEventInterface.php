<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 02/01/2014
 * Time: 20:40
 */
namespace Fridge\SubscriptionBundle\Event;

interface StripeWebhookEventInterface
{
    /**
     * @return string
     */
    public function getResponse();

    /**
     * @return string
     */
    public function getEventName();
}