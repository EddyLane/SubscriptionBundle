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
     * @param $entityClass
     */
    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;
    }

    /**
     * @param OperationFactory $operationFactory
     */
    public function __construct(OperationFactory $operationFactory)
    {
        $this->operationFactory = $operationFactory;
    }

    /**
     * @param $entity
     * @return bool
     */
    protected function matchesEntityClass(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        $em = $eventArgs->getEntityManager();
        $entityClass = $em->getClassMetadata(get_class($entity))->getName();

        return $this->entityClass === $entityClass;
    }
}
