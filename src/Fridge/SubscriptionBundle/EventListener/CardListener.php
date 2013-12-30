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
use Fridge\SubscriptionBundle\Proxy\StripeCustomer;
use Fridge\SubscriptionBundle\Proxy\StripePlan;
use Fridge\SubscriptionBundle\Entity\Card;
use Stripe_CardError;

/**
 * Class SubscriptionListener
 * @package Fridge\SubscriptionBundle\EventListener
 */
class CardListener extends AbstractEntityEventListener implements EventSubscriber
{
    /**
     * @var \Fridge\SubscriptionBundle\Proxy\StripeCustomer
     */
    protected $stripeCustomer;

    /**
     * @var string
     */
    protected $cardClass;

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return ['prePersist', 'preRemove'];
    }

    /**
     * @param StripeCustomer $stripeCustomer
     * @param $cardClass
     */
    public function __construct(StripeCustomer $stripeCustomer, $cardClass)
    {
        $this->stripeCustomer = $stripeCustomer;
        $this->cardClass = $cardClass;
    }


    /**
     * @param LifecycleEventArgs $eventArgs
     * @throws \Exception
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        $em = $eventArgs->getEntityManager();
        $entityClass = $em->getClassMetadata(get_class($entity))->getName();

        if($entityClass === $this->cardClass) {

            try {

                $customer = $this
                    ->stripeCustomer
                    ->retrieve($entity->getStripeProfile()->getStripeId())
                ;

                $cardData = $customer
                    ->cards
                    ->create([ 'card' => $entity->getToken() ])
                ;

                $entity
                    ->setToken($cardData['id'])
                    ->setCardType(Card::mapCardType($cardData['type']))
                    ->setNumber($cardData['last4'])
                    ->setExpMonth($cardData['exp_month'])
                    ->setExpYear($cardData['exp_year'])
                ;

            }
            catch(\Stripe_CardError $e) {
                throw new FridgeCardDeclinedException($e, 400, $e->getMessage());
            }

        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     * @throws CardDeclinedException
     */
    public function preRemove(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        $em = $eventArgs->getEntityManager();
        $entityClass = $em->getClassMetadata(get_class($entity))->getName();

        if($entityClass === $this->cardClass) {
            try {

                $customer = $this
                    ->stripeCustomer
                    ->retrieve($entity->getStripeProfile()->getStripeId())
                ;

                $customer
                    ->cards
                    ->retrieve($entity->getToken())
                    ->delete()
                ;

            }
            catch(\Stripe_CardError $e) {
                throw new FridgeCardDeclinedException($e, 400, $e->getMessage());
            }
        }
    }


} 