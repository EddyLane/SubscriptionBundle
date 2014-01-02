<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 02/01/2014
 * Time: 20:35
 */

namespace Fridge\SubscriptionBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class StripeWebhookEvent extends Event implements StripeWebhookEventInterface
{
    /**
     * @see https://stripe.com/docs/api#event_types
     *
     * @var string
     */
    protected $eventName;

    /** @var string */
    protected $response;

    /**
     * @param $eventName string Stripe Event name
     * @param $response string Stripe response
     */
    public function __construct($eventName, $response)
    {
        $this->$eventName = $eventName;
        $this->response   = $response;
    }

    /**
     * @return string
     */
    public function getEventName()
    {
        return $this->$eventName;
    }

    /**
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }
}