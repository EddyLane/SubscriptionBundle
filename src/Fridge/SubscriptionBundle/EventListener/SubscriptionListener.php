<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 29/12/2013
 * Time: 14:50
 */

namespace Fridge\SubscriptionBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Fridge\SubscriptionBundle\Proxy\StripePlan;

/**
 * Class SubscriptionListener
 * @package Fridge\SubscriptionBundle\EventListener
 */
class SubscriptionListener
{
    /**
     * @var \Fridge\SubscriptionBundle\Proxy\StripePlan
     */
    protected $stripePlan;

    /**
     * @var string
     */
    protected $subscriptionClass;

    /**
     * @param StripeCustomer $stripeCustomer
     * @param $subscriptionClass
     */
    public function __construct(StripePlan $stripePlan, $subscriptionClass)
    {
        $this->stripePlan = $stripePlan;
        $this->subscriptionClass = $subscriptionClass;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $eventArgs->getEntity();
        $em = $eventArgs->getEntityManager();
        $entityClass = $em->getClassMetadata(get_class($entity))->getName();

        if($entityClass === $this->subscriptionClass)
        {
            $this->stripePlan->create([
                "amount" => $entity->getPrice(),
                "interval" => "month",
                "name" => $entity->getDescription(),
                "currency" => "gbp",
                "id" => $entity->getId()
            ]);
        }
    }

} 