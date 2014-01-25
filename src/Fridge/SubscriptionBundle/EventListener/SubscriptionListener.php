<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 29/12/2013
 * Time: 14:50
 */

namespace Fridge\SubscriptionBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Fridge\SubscriptionBundle\Exception\UpdateSubscriptionException;
use Fridge\SubscriptionBundle\Proxy\StripePlan;

/**
 * Class SubscriptionListener
 * @package Fridge\SubscriptionBundle\EventListener
 */
class SubscriptionListener extends AbstractEntityEventListener implements EventSubscriber
{

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function postPersist(LifecycleEventArgs $eventArgs)
    {
        if ($this->matchesEntityClass($eventArgs)) {

            $this->operationFactory
                ->get('plan.create')
                ->getResult($eventArgs->getEntity());
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preRemove(LifecycleEventArgs $eventArgs)
    {
        if ($this->matchesEntityClass($eventArgs)) {

            $this->operationFactory
                ->get('plan.remove')
                ->getResult($eventArgs->getEntity());
        }
    }

}
