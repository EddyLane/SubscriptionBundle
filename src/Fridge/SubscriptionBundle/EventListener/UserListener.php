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
     * @param StripeCustomer $stripeCustomer
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

            die('user');
        }
    }
}