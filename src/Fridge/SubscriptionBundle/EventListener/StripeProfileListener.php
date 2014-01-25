<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 29/12/2013
 * Time: 02:19
 */

namespace Fridge\SubscriptionBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Fridge\SubscriptionBundle\Exception\FridgeCardDeclinedException;
use Fridge\SubscriptionBundle\Proxy\StripeCustomer;

class StripeProfileListener extends AbstractEntityEventListener implements EventSubscriber
{
    /**
     * @param PreUpdateEventArgs $eventArgs
     */
    public function preUpdate(PreUpdateEventArgs $eventArgs)
    {
        if(!$this->matchesEntityClass($eventArgs)) {
            return;
        }

        /*
         * Remove / Update Subscription
         */
        if($eventArgs->hasChangedField('subscription')) {
            $this->operationFactory
                ->get(is_null($eventArgs->getEntity()->getSubscription()) ? 'subscription.remove' : 'subscription.update')
                ->getResult($eventArgs->getEntity());
        }

        /*
         * Update Default Card
         */
        if($eventArgs->hasChangedField('defaultCard')) {
            $this->operationFactory
                ->get('customer.update')
                ->getResult($eventArgs->getEntity());
        }

    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        if ($this->matchesEntityClass($eventArgs)) {

            $entity = $eventArgs->getEntity();

            if($entity->getCards()->count() > 0) {

                $this->operationFactory
                    ->get('customer_and_card.create')
                    ->getResult($entity->getCards()->first());

            } else {

                $this->operationFactory
                    ->get('customer.create')
                    ->getResult($entity);

            }
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preRemove(LifecycleEventArgs $eventArgs)
    {
        if ($this->matchesEntityClass($eventArgs)) {

            $this->operationFactory
                    ->get('customer.remove')
                    ->getResult($eventArgs->getEntity());

        }
    }

}
