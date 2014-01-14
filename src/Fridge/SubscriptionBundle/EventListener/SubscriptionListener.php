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
     * @return array
     */
    public function getSubscribedEvents()
    {
        return ['postPersist', 'preRemove'];
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function postPersist(LifecycleEventArgs $eventArgs)
    {
        if ($this->matchesEntityClass($eventArgs)) {

            try {
                $this->operationFactory
                    ->get('plan.create')
                    ->getResult($eventArgs->getEntity());
            }
            catch(\Exception $e) {
                $em = $eventArgs->getEntityManager();
                $em->remove($subscription);
                $em->flush();
                throw $e;
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
                ->get('plan.remove')
                ->getResult($eventArgs->getEntity());

        }
    }

}
