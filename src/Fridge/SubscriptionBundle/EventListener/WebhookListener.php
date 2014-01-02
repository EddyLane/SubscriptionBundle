<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 02/01/2014
 * Time: 20:42
 */

namespace Fridge\SubscriptionBundle\EventListener;

use Fridge\SubscriptionBundle\Event\StripeWebhookEventInterface;
use Fridge\SubscriptionBundle\Factory\OperationFactory;
use Fridge\SubscriptionBundle\Manager\StripeProfileManager;
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
     * @var \Fridge\SubscriptionBundle\Factory\OperationFactory
     */
    protected $operationFactory;

    /**
     * @var \Fridge\SubscriptionBundle\Manager\StripeProfileManager
     */
    protected $stripeProfileManager;

    /**
     * @param LoggerInterface $logger
     * @param StripeEvent $stripeEvent
     * @param OperationFactory $operationFactory
     * @param StripeProfileManager $stripeProfileManager
     */
    public function __construct(
        LoggerInterface $logger,
        StripeEvent $stripeEvent,
        OperationFactory $operationFactory,
        StripeProfileManager $stripeProfileManager
    )
    {
        $this->logger = $logger;
        $this->stripeEvent = $stripeEvent;
        $this->operationFactory = $operationFactory;
        $this->stripeProfileManager = $stripeProfileManager;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'fridge.stripe_event.invoice.payment_failed' => 'invoicePaymentFailed',
            'fridge.stripe_event.customer.subscription.deleted' => 'customerSubscriptionDeleted'
        ];
    }

    /**
     * @param StripeWebhookEventInterface $event
     * @return mixed
     */
    protected function getStripeEvent(StripeWebhookEventInterface $event)
    {
        return $this->stripeEvent->retrieve($event->getResponse()['id']);
    }


    /**
     * @param StripeWebhookEventInterface $event
     */
    public function customerSubscriptionDeleted(StripeWebhookEventInterface $event)
    {
        try {
            $event = $this->getStripeEvent($event);

            if($event['type'] !== 'customer.subscription.deleted') {
                throw new \Exception('Unexpected event type.');
            }

            $stripeProfile = $this->stripeProfileManager->findOneByStripeId($event->data->object->customer);

            $stripeProfile->setSubscription(null)
                ->setSubscriptionEnd(null)
                ->setSubscriptionStart(null);

            $this->stripeProfileManager->save($stripeProfile, true);

            $this->logger->info('STRIPE LIVE CUSTOMER SUBSCRIPTION DELETED RECIEVED');
        }
        catch(\Exception $e) {
            $this->logger->info('STRIPE TEST CUSTOMER SUBSCRIPTION DELETED RECIEVED');
        }
    }

    /**
     * @param StripeWebhookEventInterface $event
     */
    public function invoicePaymentFailed(StripeWebhookEventInterface $event)
    {
        try {
            $event = $this->getStripeEvent($event);

            if($event['type'] !== 'invoice.payment_failed') {
                throw new \Exception('Unexpected event type.');
            }

            $stripeProfile = $this->stripeProfileManager->findOneByStripeId($event->data->object->customer);

            $this->logger->info('STRIPE LIVE EVENT INVOICE PAYMENT FAILED RECIEVED');
        }
        catch(\Exception $e) {
            $this->logger->info('STRIPE TEST EVENT INVOICE PAYMENT FAILED RECIEVED');
        }
    }

}