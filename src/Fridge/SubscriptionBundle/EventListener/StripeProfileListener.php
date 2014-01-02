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
     * @return array
     */
    public function getSubscribedEvents()
    {
        return ['prePersist', 'preUpdate'];
    }

    /**
     * @param PreUpdateEventArgs $eventArgs
     */
    public function preUpdate(PreUpdateEventArgs $eventArgs)
    {
        if($this->matchesEntityClass($eventArgs) && $eventArgs->hasChangedField('subscription')) {

            if(is_null($eventArgs->getEntity()->getSubscription())) {

                $this->operationFactory
                    ->get('subscription.remove')
                    ->getResult($eventArgs->getEntity());

            } else {

                $this->operationFactory
                    ->get('subscription.update')
                    ->getResult($eventArgs->getEntity());

            }

        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        if ($this->matchesEntityClass($eventArgs)) {

            $this->operationFactory
                 ->get('customer.create')
                 ->getResult($eventArgs->getEntity());

        }
    }

}
