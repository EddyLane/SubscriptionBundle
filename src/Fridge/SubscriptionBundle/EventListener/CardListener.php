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
     * @param  LifecycleEventArgs $eventArgs
     * @throws \Exception
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        //Have to check that there is no token incase already been created with a CustomerAndCardCreateOperation
        if ($this->matchesEntityClass($eventArgs) && !$eventArgs->getEntity()->getNumber()) {

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
        if ($this->matchesEntityClass($eventArgs) && $eventArgs->getEntity()->getToken()) {

            $this->operationFactory
                 ->get('card.remove')
                 ->getResult($eventArgs->getEntity());

        }
    }

}