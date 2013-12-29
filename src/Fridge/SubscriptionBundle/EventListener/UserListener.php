<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 29/12/2013
 * Time: 02:19
 */

namespace Fridge\SubscriptionBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\DependencyInjection\Container;
use Fridge\SubscriptionBundle\Proxy\StripeCustomer;

class UserListener {

    /**
     * @param Container $container
     * @param StripeProxy $stripeProxy
     */
    public function __construct(Container $container, StripeCustomer $stripeCustomer)
    {
        $this->container = $container;
        $this->stripeCustomer = $stripeCustomer;
    }

    /**
     * @param PreUpdateEventArgs $eventArgs
     */
    public function preUpdate(PreUpdateEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();

        if ($entity instanceof User) {

            if(!$entity->getStripeId() || !$entity->getSubscription() || !$eventArgs->hasChangedField('subscription')) {
                return;
            }

            try {
                $customer = $this
                    ->stripeProxy
                    ->retrieveCustomer($entity->getStripeId())
                ;

                $subscriptionData = $customer->updateSubscription(["plan" => $entity->getSubscription()->getName(), "prorate" => true]);

                $entity->setSubscriptionStart(new \DateTime('@' . $subscriptionData['current_period_start']));
                $entity->setSubscriptionEnd(new \DateTime('@' . $subscriptionData['current_period_end']));

            }
            catch(\Stripe_CardError $e) {
                //throw new CardDeclinedException($e->getMessage());
            }

        }
    }
}