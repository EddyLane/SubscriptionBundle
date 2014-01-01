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
use Fridge\SubscriptionBundle\Exception\FridgeCardDeclinedException;
use Fridge\SubscriptionBundle\Factory\OperationFactory;
use Fridge\SubscriptionBundle\Proxy\StripeCustomer;
use Fridge\SubscriptionBundle\Entity\Card;
use Stripe_CardError;

/**
 * Class SubscriptionListener
 * @package Fridge\SubscriptionBundle\EventListener
 */
class CardListener extends AbstractEntityEventListener implements EventSubscriber
{

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return ['prePersist', 'preRemove'];
    }

    /**
     * @param  LifecycleEventArgs $eventArgs
     * @throws \Exception
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        if ($this->matchesEntityClass($eventArgs)) {

            $this->operationFactory
                ->get('card.create')
                ->getResult($eventArgs->getEntity());

        }
    }

    /**
     * @param  LifecycleEventArgs    $eventArgs
     * @throws CardDeclinedException
     */
    public function preRemove(LifecycleEventArgs $eventArgs)
    {
        if ($this->matchesEntityClass($eventArgs)) {

            $this->operationFactory
                 ->get('card.remove')
                 ->getResult($eventArgs->getEntity());

        }
    }

}