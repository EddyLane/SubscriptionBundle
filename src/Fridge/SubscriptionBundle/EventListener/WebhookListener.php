<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 02/01/2014
 * Time: 20:42
 */

namespace Fridge\SubscriptionBundle\EventListener;

use Fridge\SubscriptionBundle\Event\StripeWebhookEventInterface;
use Fridge\SubscriptionBundle\Proxy\StripeEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

/**
 * Class WebhookListener
 * @package Fridge\SubscriptionBundle\EventListener
 */
class WebhookListener implements EventSubscriberInterface
{
    /**
     * @var \Symfony\Component\HttpKernel\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var \Fridge\SubscriptionBundle\Proxy\StripeEvent
     */
    protected $stripeEvent;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger, StripeEvent $stripeEvent)
    {
        $this->logger = $logger;
        $this->stripeEvent = $stripeEvent;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'fridge.stripe_event.invoice.payment_failed' => 'invoicePaymentFailed'
        ];
    }

    /**
     * @param StripeWebhookEventInterface $event
     */
    public function invoicePaymentFailed(StripeWebhookEventInterface $event)
    {
        $this->logger->info('STRIPE EVENT RECIEVED');
    }

}