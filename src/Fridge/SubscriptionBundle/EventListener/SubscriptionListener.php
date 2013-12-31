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
use Fridge\SubscriptionBundle\Proxy\StripePlan;

/**
 * Class SubscriptionListener
 * @package Fridge\SubscriptionBundle\EventListener
 */
class SubscriptionListener extends AbstractEntityEventListener implements EventSubscriber
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
     *                                       @param $subscriptionClass
     */
    public function __construct(StripePlan $stripePlan, $subscriptionClass)
    {
        $this->stripePlan = $stripePlan;
        $this->subscriptionClass = $subscriptionClass;
    }

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
        $entity = $eventArgs->getEntity();
        $em = $eventArgs->getEntityManager();
        $entityClass = $em->getClassMetadata(get_class($entity))->getName();

        if ($entityClass === $this->subscriptionClass) {
            try {
                $this->stripePlan->create([
                    "amount" => $entity->getPrice(),
                    "interval" => "month",
                    "name" => $entity->getDescription(),
                    "currency" => "gbp",
                    "id" => $entity->getId()
                ]);
            } catch (\Exception $e) {
                $em->remove($entity);
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
        $entity = $eventArgs->getEntity();
        $em = $eventArgs->getEntityManager();
        $entityClass = $em->getClassMetadata(get_class($entity))->getName();

        if ($entityClass === $this->subscriptionClass) {
            $plan = $this->stripePlan->retrieve($entity->getId());
            $plan->delete();
        }
    }

}
