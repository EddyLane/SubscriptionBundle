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
use Symfony\Component\DependencyInjection\Container;
use Fridge\SubscriptionBundle\Proxy\StripeCustomer;
use Doctrine\ORM\EntityManager;

class StripeProfileListener extends AbstractEntityEventListener implements EventSubscriber
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
     * @return array
     */
    public function getSubscribedEvents()
    {
        return ['prePersist', 'preUpdate'];
    }

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

            if(!$entity->getStripeId() || !$eventArgs->hasChangedField('subscription')) {
                return;
            }

            try {
                $customer = $this
                    ->stripeCustomer
                    ->retrieve($entity->getStripeId())
                ;

                $subscriptionData = $customer->updateSubscription([
                    "plan" => $entity->getSubscription()->getId(),
                    "prorate" => true
                ]);

                $entity->setSubscriptionStart(new \DateTime('@' . $subscriptionData['current_period_start']));
                $entity->setSubscriptionEnd(new \DateTime('@' . $subscriptionData['current_period_end']));

            }
            catch(\Stripe_CardError $e) {
                throw new FridgeCardDeclinedException($e, 400, $e->getMessage());
            }
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

            try {
                $stripeResponse = $this->stripeCustomer->create([
                    'description' => 'customer'
                ]);

                $entity->setStripeId($stripeResponse['id']);

            }
            catch(\Stripe_CardError $e) {
                throw new FridgeCardDeclinedException($e, 400, $e->getMessage());
            }

        }
    }

}