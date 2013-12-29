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
use Doctrine\ORM\EntityManager;

class StripeProfileListener
{
    /**
     * @var \Fridge\SubscriptionBundle\Proxy\StripeCustomer
     */
    protected $stripeCustomer;

    /**
     * @var string
     */
    protected $profileClass;

    /**
     * @param StripeCustomer $stripeCustomer
     * @param $profileClass
     */
    public function __construct(StripeCustomer $stripeCustomer, $profileClass)
    {
        $this->stripeCustomer = $stripeCustomer;
        $this->profileClass = $profileClass;
    }

    /**
     * @param PreUpdateEventArgs $eventArgs
     */
    public function preUpdate(PreUpdateEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        $em = $eventArgs->getEntityManager();
        $entityClass = $em->getClassMetadata(get_class($entity))->getName();

        if($entityClass === $this->profileClass) {
            die('PROFILE CLASS BABY. PREUPDATE');
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        $em = $eventArgs->getEntityManager();
        $entityClass = $em->getClassMetadata(get_class($entity))->getName();

        if($entityClass === $this->profileClass) {
            die('PROFILE CLASS BABY. PREPERSIST');
        }
    }

}