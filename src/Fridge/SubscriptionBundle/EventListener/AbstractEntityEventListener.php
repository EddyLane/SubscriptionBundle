<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 29/12/2013
 * Time: 15:50
 */

namespace Fridge\SubscriptionBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Fridge\SubscriptionBundle\Factory\OperationFactory;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Class AbstractEntityEventListener
 * @package Fridge\SubscriptionBundle\EventListener
 */
abstract class AbstractEntityEventListener
{
    /**
     * @var OperationFactory
     */
    protected $operationFactory;

    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var array
     */
    protected $events = [];

    /**
     * @var boolean
     */
    protected $enabled;

    /**
     * @param $entityClass
     */
    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        if (!$this->enabled) {
            return [];
        }
        return $this->events;
    }

    /**
     * @param array $events
     * @return $this
     */
    public function setSubscribedEvents(array $events = [])
    {
        $this->events = $events;

        return $this;
    }

    /**
     * @param OperationFactory $operationFactory    creates operations
     * @param $enabled                              boolean to disable this event
     */
    public function __construct(OperationFactory $operationFactory, $enabled)
    {
        $this->operationFactory = $operationFactory;
        $this->enabled = $enabled;
    }

    /**
     * @param $entity
     * @return bool
     */
    public function matchesEntityClass(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        $em = $eventArgs->getEntityManager();
        $entityClass = $em->getClassMetadata(get_class($entity))->getName();

        return $entityClass === $this->entityClass || is_subclass_of($entity, $this->entityClass);
    }
}
